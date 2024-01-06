<?php

namespace App\Http\Controllers\User;

use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\BasicSettings;
use App\Models\Admin\Currency;
use App\Models\Admin\PaymentGateway;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Models\Transaction;
use App\Models\UserNotification;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Traits\ControlDynamicInputFields;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class WithdrawController extends Controller
{
    use ControlDynamicInputFields;

    public function index()
    {
        $page_title = "Withdraw Money";
        $user_wallets = UserWallet::auth()->get();
        $user_currencies = Currency::whereIn('id',$user_wallets->pluck('id')->toArray())->get();
        $payment_gateways = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::money_out_slug());
            $gateway->where('status', 1);
        })->get();
        $transactions = Transaction::auth()->withdrawMoney()->orderByDesc("id")->latest()->take(10)->get();
        return view('user.sections.withdraw.index',compact('page_title','payment_gateways','transactions','user_wallets'));
    }
    public function paymentInsert(Request $request){
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'gateway' => 'required'
        ]);
        $user = auth()->user();
        $userWallet = UserWallet::where('user_id',$user->id)->where('status',1)->first();
        $gate =PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::money_out_slug());
            $gateway->where('status', 1);
        })->where('alias',$request->gateway)->first();
        $baseCurrency = Currency::default();
        if (!$gate) {
            return back()->with(['error' => ['Invalid Gateway']]);
        }
        $amount = $request->amount;
        $min_limit =  $gate->min_limit / $gate->rate;
        $max_limit =  $gate->max_limit / $gate->rate;
        if($amount < $min_limit || $amount > $max_limit) {
            return back()->with(['error' => ['Please follow the transaction limit']]);
        }
        //gateway charge
        $fixedCharge = $gate->fixed_charge;
        $percent_charge =  (((($request->amount)/ 100) * $gate->percent_charge));
        $charge = $fixedCharge + $percent_charge;
        $conversion_amount = $request->amount * $gate->rate;
        $will_get = $conversion_amount;

        //base_cur_charge
        $baseFixedCharge = $gate->fixed_charge /  $gate->rate;
        $basePercent_charge = (($request->amount / 100) * $gate->percent_charge)/ $gate->rate;
        $base_total_charge = $baseFixedCharge + $basePercent_charge;
        $reduceAbleTotal = $amount + $base_total_charge;

        if( $reduceAbleTotal > $userWallet->balance){
            return back()->with(['error' => ['Insufficient Balance On Your Wallet']]);
        }
        $data['user_id']= $user->id;
        $data['gateway_name']= $gate->gateway->name;
        $data['gateway_type']= $gate->gateway->type;
        $data['wallet_id']= $userWallet->id;
        $data['trx_id']= 'WM'.getTrxNum();
        $data['amount'] =  $amount;
        $data['base_cur_fixed_charge'] = $baseFixedCharge;
        $data['base_cur_percent_charge'] = $basePercent_charge;
        $data['base_cur_charge'] = $base_total_charge;
        $data['base_cur_rate'] = $baseCurrency->rate;
        $data['gateway_id'] = $gate->gateway->id;
        $data['gateway_currency_id'] = $gate->id;
        $data['gateway_currency'] = strtoupper($gate->currency_code);
        $data['gateway_percent_charge'] = $percent_charge;
        $data['gateway_fixed_charge'] = $fixedCharge;
        $data['gateway_charge'] = $charge;
        $data['gateway_rate'] = $gate->rate;
        $data['conversion_amount'] = $conversion_amount;
        $data['will_get'] = $will_get;
        $data['payable'] = $reduceAbleTotal;
        session()->put('moneyoutData', $data);
        return redirect()->route('user.withdraw.preview');
   }

   public function preview(){
        $moneyOutData = (object)session()->get('moneyoutData');
        $moneyOutDataExist = session()->get('moneyoutData');
        if($moneyOutDataExist  == null){
            return redirect()->route('user.withdraw.index');
        }
        $gateway = PaymentGateway::where('id', $moneyOutData->gateway_id)->first();
        if($gateway->type == "AUTOMATIC"){
            $page_title = "Withdraw Via ".$gateway->name;
            return back()->with(['error' => ["Something is wrong, please try again later"]]);
        }else{

            $page_title = "Withdraw Via ".$gateway->name;
            return view('user.sections.withdraw.preview',compact('page_title','gateway','moneyOutData'));

        }

   }

   public function confirmMoneyOut(Request $request){
    $basic_setting = BasicSettings::first();
    $moneyOutData = (object)session()->get('moneyoutData');
    $gateway = PaymentGateway::where('id', $moneyOutData->gateway_id)->first();
    $payment_fields = $gateway->input_fields ?? [];

    $validation_rules = $this->generateValidationRules($payment_fields);
    $payment_field_validate = Validator::make($request->all(),$validation_rules)->validate();
    $get_values = $this->placeValueWithFields($payment_fields,$payment_field_validate);
        try{
            $inserted_id = $this->insertRecordManual($moneyOutData,$gateway,$get_values);
            $this->insertChargesManual($moneyOutData,$inserted_id);
            $this->insertDeviceManual($moneyOutData,$inserted_id);
            session()->forget('moneyoutData');

            return redirect()->route("user.withdraw.index")->with(['success' => ['Withdraw Money Request Send To Admin Successful']]);
        }catch(Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }

   }
    public function insertRecordManual($moneyOutData,$gateway,$get_values) {
        if($moneyOutData->gateway_type == "AUTOMATIC"){
            $status = 1;
        }else{
            $status = 2;
        }
        $details = [
            'user_data' => $get_values,
            'withdraw_data' => $moneyOutData,
        ];
        $trx_id = $moneyOutData->trx_id ??'MO'.getTrxNum();
        $authWallet = UserWallet::where('id',$moneyOutData->wallet_id)->where('user_id',$moneyOutData->user_id)->first();
        $afterCharge = ($authWallet->balance - ($moneyOutData->payable));
        DB::beginTransaction();
        try{
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => auth()->user()->id,
                'user_wallet_id'                => $moneyOutData->wallet_id,
                'payment_gateway_currency_id'   => $moneyOutData->gateway_currency_id,
                'type'                          => PaymentGatewayConst::WITHDRAWMONEY,
                'trx_id'                        => $trx_id,
                'request_amount'                => $moneyOutData->amount,
                'payable'                       => $moneyOutData->payable,
                'available_balance'             => $afterCharge,
                'remark'                        => ucwords(remove_speacial_char(PaymentGatewayConst::WITHDRAWMONEY," ")) . " by " .$gateway->name,
                'details'                       => json_encode($details),
                'status'                        => $status,
                'created_at'                    => now(),
            ]);
            $this->updateWalletBalanceManual($authWallet,$afterCharge);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return $id;
    }
    public function updateWalletBalanceManual($authWalle,$afterCharge) {
        $authWalle->update([
            'balance'   => $afterCharge,
        ]);
    }
    public function insertChargesManual($moneyOutData,$id) {

        if(Auth::guard(get_auth_guard())->check()){
            $user = auth()->guard(get_auth_guard())->user();
        }
        DB::beginTransaction();
        try{
            DB::table('transaction_charges')->insert([
                'transaction_id'    => $id,
                'percent_charge'    => $moneyOutData->base_cur_percent_charge,
                'fixed_charge'      => $moneyOutData->base_cur_fixed_charge,
                'total_charge'      => $moneyOutData->base_cur_charge,
                'created_at'        => now(),
            ]);
            DB::commit();

            //notification
            $notification_content = [
                'title'         => "Withdraw",
                'message'       => "Your Withdraw Request Send To Admin " .$moneyOutData->amount.' '.get_default_currency_code()." Successful",
                'image'         => get_image($user->image,'user-profile'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::WITHDRAWMONEY,
                'user_id'  =>  auth()->user()->id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function insertDeviceManual($output,$id) {
        $client_ip = request()->ip() ?? false;
        $location = geoip()->getLocation($client_ip);
        $agent = new Agent();

        // $mac = exec('getmac');
        // $mac = explode(" ",$mac);
        // $mac = array_shift($mac);
        $mac = "";

        DB::beginTransaction();
        try{
            DB::table("transaction_devices")->insert([
                'transaction_id'=> $id,
                'ip'            => $client_ip,
                'mac'           => $mac,
                'city'          => $location['city'] ?? "",
                'country'       => $location['country'] ?? "",
                'longitude'     => $location['lon'] ?? "",
                'latitude'      => $location['lat'] ?? "",
                'timezone'      => $location['timezone'] ?? "",
                'browser'       => $agent->browser() ?? "",
                'os'            => $agent->platform() ?? "",
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
