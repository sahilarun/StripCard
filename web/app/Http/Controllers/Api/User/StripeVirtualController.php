<?php

namespace App\Http\Controllers\Api\User;

use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers;
use App\Models\Admin\BasicSettings;
use App\Models\Admin\Currency;
use App\Models\Admin\TransactionSetting;
use App\Models\StripeVirtualCard;
use App\Models\Transaction;
use App\Models\UserNotification;
use App\Models\UserWallet;
use App\Models\VirtualCardApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StripeVirtualController extends Controller
{
    protected $api;
    public function __construct()
    {
        $cardApi = VirtualCardApi::first();
        $this->api =  $cardApi;
    }
    public function index()
    {
        $user = auth()->user();
        $basic_settings = BasicSettings::first();
        $card_basic_info = [
            'card_back_details' => @$this->api->card_details,
            'card_bg' => get_image(@$this->api->image,'card-api'),
            'site_title' =>@$basic_settings->site_name,
            'site_logo' =>get_logo(@$basic_settings,'dark'),
            'site_fav' =>get_fav($basic_settings,'dark'),
        ];
        $myCards = StripeVirtualCard::where('user_id',$user->id)->orderBy('id','DESC')->get()->map(function($data){
            $basic_settings = BasicSettings::first();
            $statusInfo = [
                "active" =>      1,
                "inactive" =>     0,
                ];
            return[
                'id' => $data->id,
                'card_id' => $data->card_id,
                'currency' => $data->currency,
                'card_holder' => $data->name,
                'brand' => $data->brand,
                'type' => $data->type,
                'card_pan' => $data->maskedPan,
                'expiry_month' => $data->expiryMonth,
                'expiry_year' => $data->expiryYear,
                'cvv' => "***",
                'card_back_details' => @$this->api->card_details,
                'site_title' =>@$basic_settings->site_name,
                'site_logo' =>get_logo(@$basic_settings,'dark'),
                'status' => $data->status,
                'status_info' =>(object)$statusInfo ,
            ];
        });
        $cardCharge = TransactionSetting::where('slug','virtual_card')->where('status',1)->get()->map(function($data){
            return [
                'id' => $data->id,
                'slug' => $data->slug,
                'title' => $data->title,
                'fixed_charge' => getAmount($data->fixed_charge,2),
                'percent_charge' => getAmount($data->percent_charge,2),
                'min_limit' => getAmount($data->min_limit,2),
                'max_limit' => getAmount($data->max_limit,2),
            ];
        })->first();
        $transactions = Transaction::auth()->virtualCard()->latest()->take(10)->get()->map(function($item){
            $statusInfo = [
                "success" =>      1,
                "pending" =>      2,
                "rejected" =>     3,
                ];
            return[
                'id' => $item->id,
                'trx' => $item->trx_id,
                'transaction_type' => "Virtual Card".'('. @$item->remark.')',
                'request_amount' => getAmount($item->request_amount,2).' '.get_default_currency_code() ,
                'payable' => getAmount($item->payable,2).' '.get_default_currency_code(),
                'total_charge' => getAmount($item->charge->total_charge,2).' '.get_default_currency_code(),
                'card_amount' => getAmount(@$item->details->card_info->amount,2).' '.get_default_currency_code(),
                'card_number' => $item->details->card_info->card_pan??$item->details->card_info->maskedPan,
                'current_balance' => getAmount($item->available_balance,2).' '.get_default_currency_code(),
                'status' => $item->stringStatus->value ,
                'date_time' => $item->created_at ,
                'status_info' =>(object)$statusInfo ,

            ];
        });
        $userWallet = UserWallet::where('user_id',$user->id)->get()->map(function($data){
            return[
                'balance' => getAmount($data->balance,2),
                'currency' => get_default_currency_code(),
            ];
        })->first();

        $data =[
            'base_curr' => get_default_currency_code(),
            'card_basic_info' =>(object) $card_basic_info,
            'myCard'=> $myCards,
            'userWallet'=>  (object)$userWallet,
            'cardCharge'=>(object)$cardCharge,
            'transactions'   => $transactions,
        ];
        $message =  ['success'=>['Virtual Card Stripe']];
        return Helpers::success($data,$message);
    }
    public function cardDetails(){
        $validator = Validator::make(request()->all(), [
            'card_id'     => "required|string",
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $card_id = request()->card_id;
        $user = auth()->user();
        $myCard = StripeVirtualCard::where('user_id',$user->id)->where('card_id',$card_id)->first();
        if(!$myCard){
            $error = ['error'=>['Sorry, card not found!']];
            return Helpers::error($error);
        }
        $myCards = StripeVirtualCard::where('card_id',$card_id)->where('user_id',$user->id)->get()->map(function($data){
            $basic_settings = BasicSettings::first();
            $statusInfo = [
                "active" =>      1,
                "inactive" =>     0,
                ];

            return[
                'id' => $data->id,
                'card_id' => $data->card_id,
                'currency' => $data->currency,
                'card_holder' => $data->name,
                'brand' => $data->brand,
                'type' => $data->type,
                'card_pan' => $data->maskedPan,
                'expiry_month' => $data->expiryMonth,
                'expiry_year' => $data->expiryYear,
                'cvv' => "***",
                'card_back_details' => @$this->api->card_details,
                'site_title' =>@$basic_settings->site_name,
                'site_logo' =>get_logo(@$basic_settings,'dark'),
                'status' => $data->status,
                'status_info' =>(object)$statusInfo ,
            ];
        })->first();
        $data =[
            'base_curr' => get_default_currency_code(),
            'card_details'=> $myCards,
        ];
        $message =  ['success'=>['Virtual Card Details']];
        return Helpers::success($data,$message);
    }
    public function cardTransaction() {
        $validator = Validator::make(request()->all(), [
            'card_id'     => "required|string",
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $card_id = request()->card_id;
        $user = auth()->user();
        $card = StripeVirtualCard::where('user_id',$user->id)->where('card_id',$card_id)->first();
        if(!$card){
            $error = ['error'=>['Sorry, Card Not Found!']];
            return Helpers::error($error);
        }
        $card_truns =   getStripeCardTransactions($card->card_id);
        $cardTransactions = collect($card_truns['data'])->map(function ($transaction) {
            $card_id = request()->card_id;
            $user = auth()->user();
            $card = StripeVirtualCard::where('user_id',$user->id)->where('card_id',$card_id)->first();
            return [
                'id' => $transaction['id'],
                'amount' => $transaction['amount']/100,
                'currency' => $transaction['currency'],
                'type' => $transaction['type'],
                'card_number' =>"....". $card->last4,
                'card_holder' =>$card->name,
                'descriptions' =>$transaction['merchant_data']->name,
            ];
        });
        $data = [
            'cardTransactions' => $cardTransactions
        ];

        $message = ['success' => ['Virtual Card Transactions']];
        return Helpers::success($data, $message);


    }
    public function getSensitiveData(Request $request){
        $validator = Validator::make($request->all(), [
            'card_id'     => "required|string",
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $validated = $validator->validate();
        $user = auth()->user();
        $targetCard =  StripeVirtualCard::where('card_id',$validated['card_id'])->where('user_id',$user->id)->first();
        if(!$targetCard){
            $error = ['error'=>['Something Is Wrong In Your Card']];
            return Helpers::error($error);
        };
        $result = getSensitiveData( $targetCard->card_id);

        $data =[
            'sensitive_data' => $result,
        ];
        $message =  ['success'=>['Virtual Card Sensitive Data']];
        return Helpers::success($data,$message);
    }
    public function cardInactive(Request $request){
        $validator = Validator::make($request->all(), [
            'card_id'     => "required|string",
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $card_id = $request->card_id;
        $user = auth()->user();
        $status = 'inactive';
        $card = StripeVirtualCard::where('user_id',$user->id)->where('card_id',$card_id)->first();
        if(!$card){
            $error = ['error'=>['Something Is Wrong In Your Card']];
            return Helpers::error($error);
        }
        if($card->status == false){
            $error = ['error'=>['Sorry,This Card Is Already Inactive']];
            return Helpers::error($error);
        }
        $result = cardActiveInactive($card->card_id,$status);
        if(isset($result['status'])){
            if($result['status'] == true){
                $card->status = false;
                $card->save();
                $message =  ['success'=>['Card Inactive Successfully!']];
                return Helpers::onlysuccess($message);
            }elseif($result['status'] == false){
                $error = ['error'=>[$result['message']??"Something Is Wrong"]];
                return Helpers::error($error);
            }
        }

    }
    public function cardActive(Request $request){
        $validator = Validator::make($request->all(), [
            'card_id'     => "required|string",
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $card_id = $request->card_id;
        $user = auth()->user();
        $status = 'active';
        $card = StripeVirtualCard::where('user_id',$user->id)->where('card_id',$card_id)->first();
        if(!$card){
            $error = ['error'=>['Something Is Wrong In Your Card']];
            return Helpers::error($error);
        }
        if($card->status == true){
            $error = ['error'=>['Sorry,This Card Is Already Active']];
            return Helpers::error($error);
        }
        $result = cardActiveInactive($card->card_id,$status);
        if(isset($result['status'])){
            if($result['status'] == true){
                $card->status = true;
                $card->save();
                $message =  ['success'=>['Card Active Successfully!']];
                return Helpers::onlysuccess($message);
            }elseif($result['status'] == false){
                $error = ['error'=>[$result['message']??"Something Is Wrong"]];
                return Helpers::error($error);
            }
        }

    }
    public function cardBuy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fund_amount' => 'required|numeric|gt:0',
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $basic_setting = BasicSettings::first();
        $user = auth()->user();
        if($basic_setting->kyc_verification){
            if( $user->kyc_verified == 0){
                $error = ['error'=>['Please submit kyc information!']];
                return Helpers::error($error);
            }elseif($user->kyc_verified == 2){
                $error = ['error'=>['Please wait before admin approved your kyc information']];
                return Helpers::error($error);
            }elseif($user->kyc_verified == 3){
                $error = ['error'=>['Admin rejected your kyc information, Please re-submit again']];
                return Helpers::error($error);
            }
        }
        $amount = $request->fund_amount;
        $wallet = UserWallet::where('user_id',$user->id)->first();
        if(!$wallet){
            $error = ['error'=>['Wallet Not Found']];
            return Helpers::error($error);
        }
        $cardCharge = TransactionSetting::where('slug','virtual_card')->where('status',1)->first();
        $baseCurrency = Currency::default();

        if(!$baseCurrency){
            $error = ['error'=>['Default Currency Not Setup Yet']];
            return Helpers::error($error);
        }
        $rate = $baseCurrency->rate;

        $minLimit =  $cardCharge->min_limit *  $rate;
        $maxLimit =  $cardCharge->max_limit *  $rate;

        if($amount < $minLimit || $amount > $maxLimit) {
            $error = ['error'=>['Please follow the transaction limit']];
            return Helpers::error($error);
        }

        //charge calculations
        $fixedCharge = $cardCharge->fixed_charge *  $rate;
        $percent_charge = ($amount / 100) * $cardCharge->percent_charge;
        $total_charge = $fixedCharge + $percent_charge;
        $payable = $total_charge + $amount;
        if($payable > $wallet->balance ){
            $error = ['error'=>['Sorry, insufficient balance']];
            return Helpers::error($error);
        }

        //create connected account
       if( $user->stripe_connected_account == null){
        $c_account =  createConnectAccount($user);
        if( isset($c_account['status'])){
           if($c_account['status'] == false){
            $error = ['error'=>[$c_account['message']]];
            return Helpers::error($error);
           }
        }
        $stripe_connected_account_data =[
            'id' => $c_account['data']['id'],
            'object' => $c_account['data']['object'],
            'business_profile' => $c_account['data']['business_profile'],
            'business_type' => $c_account['data']['business_type'],
            'capabilities' => $c_account['data']['capabilities'],
            'charges_enabled' => $c_account['data']['charges_enabled'],
            'country' => $c_account['data']['country'],
            'created' => $c_account['data']['created'],
            'default_currency' => $c_account['data']['default_currency'],
            'details_submitted' => $c_account['data']['details_submitted'],
            'external_accounts' => $c_account['data']['external_accounts'],
            'future_requirements' => $c_account['data']['future_requirements'],
            'metadata' => $c_account['data']['metadata'],
            'payouts_enabled' => $c_account['data']['payouts_enabled'],
            'requirements' => $c_account['data']['requirements'],
            'settings' => $c_account['data']['settings'],
            'tos_acceptance' => $c_account['data']['tos_acceptance'],
            'type' => $c_account['data']['type'],

        ];
        $stripe_connected_account_data = (object)$stripe_connected_account_data;
        $user->stripe_connected_account = $stripe_connected_account_data;
        $user->save();
        $c_account = $user->stripe_connected_account->id;

       }else{
        $c_account = $user->stripe_connected_account->id;
       }

    //check card holder have or not
       if( $user->stripe_card_holders == null){
        $card_holder =  createCardHolders($user,$c_account);
        if( isset($card_holder['status'])){
           if($card_holder['status'] == false){
            $error = ['error'=>[$card_holder['message']]];
            return Helpers::error($error);
           }
        }
        $stripe_card_holders_data =[
            'id' => $c_account['data']['id'],
        ];
        $stripe_card_holders_data = (object)$stripe_card_holders_data;

        $user->stripe_card_holders =   (object)$stripe_card_holders_data;
        $user->save();
        $card_holder_id = $user->stripe_card_holders->id;

       }else{
        $card_holder_id = $user->stripe_card_holders->id;
       }

       //create card now
       $created_card = createVirtualCard($card_holder_id,$c_account);
       if(isset($created_card['status'])){
            if($created_card['status'] == false){
                $error = ['error'=>[$created_card['message']]];
                return Helpers::error($error);
            }
       }

        //account update
        $account_update = updateAccount($c_account);
        if(isset($account_update['status'])){
            if($account_update['status'] == false){
                $error = ['error'=>[$account_update['message']]];
                return Helpers::error($error);
            }
        }

       //now funded amount
       $funded_amount = transfer($amount,  $c_account);
       if(isset($funded_amount['status'])){
            if($funded_amount['status'] == false){
                $error = ['error'=>[$funded_amount['message']]];
                return Helpers::error($error);
            }
        }
       if($created_card['status']  = true){
            $card_info = (object)$created_card['data'];
            $v_card = new StripeVirtualCard();
            $v_card->user_id = $user->id;
            $v_card->name = $user->fullname;
            $v_card->card_id = $card_info->id;
            $v_card->type = $card_info->type;
            $v_card->brand = $card_info->brand;
            $v_card->currency = $card_info->currency;
            $v_card->amount = $amount;
            $v_card->charge = $total_charge;
            $v_card->maskedPan = "0000********".$card_info->last4;
            $v_card->last4 = $card_info->last4;
            $v_card->expiryMonth = $card_info->exp_month;
            $v_card->expiryYear = $card_info->exp_year;
            $v_card->status = true;
            $v_card->card_details = $card_info;
            $v_card->save();

            $trx_id =  'CB'.getTrxNum();
            try{
                $sender = $this->insertCardBuy( $trx_id,$user,$wallet,$amount, $v_card ,$payable);
                $this->insertBuyCardCharge( $fixedCharge,$percent_charge, $total_charge,$user,$sender,$v_card->maskedPan);
                $message =  ['success'=>['Card Buy Successfully']];
                return Helpers::onlysuccess($message);
            }catch(Exception $e){
                $error = ['error'=>["Something Went Wrong! Please Try Again."]];
                return Helpers::error($error);
            }

       }

    }
    //card buy helper
     public function insertCardBuy( $trx_id,$user,$wallet,$amount, $v_card ,$payable) {
        $trx_id = $trx_id;
        $authWallet = $wallet;
        $afterCharge = ($authWallet->balance - $payable);
        $details =[
            'card_info' =>   $v_card??''
        ];
        DB::beginTransaction();
        try{
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => $user->id,
                'user_wallet_id'                => $authWallet->id,
                'payment_gateway_currency_id'   => null,
                'type'                          => PaymentGatewayConst::VIRTUALCARD,
                'trx_id'                        => $trx_id,
                'request_amount'                => $amount,
                'payable'                       => $payable,
                'available_balance'             => $afterCharge,
                'remark'                        => ucwords(remove_speacial_char(PaymentGatewayConst::CARDBUY," ")),
                'details'                       => json_encode($details),
                'attribute'                      =>PaymentGatewayConst::RECEIVED,
                'status'                        => true,
                'created_at'                    => now(),
            ]);
            $this->updateSenderWalletBalance($authWallet,$afterCharge);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            $error = ['error'=>['Something went wrong! Please try again']];
            return Helpers::error($error);
        }
        return $id;
    }
    public function insertBuyCardCharge($fixedCharge,$percent_charge, $total_charge,$user,$id,$masked_card) {
        DB::beginTransaction();
        try{
            DB::table('transaction_charges')->insert([
                'transaction_id'    => $id,
                'percent_charge'    => $percent_charge,
                'fixed_charge'      =>$fixedCharge,
                'total_charge'      =>$total_charge,
                'created_at'        => now(),
            ]);
            DB::commit();

            //notification
            $notification_content = [
                'title'         =>"Buy Card ",
                'message'       => "Buy card successful ".$masked_card,
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::CARD_BUY,
                'user_id'  => $user->id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            $error = ['error'=>['Something went wrong! Please try again']];
            return Helpers::error($error);
        }
    }
    //update user balance
    public function updateSenderWalletBalance($authWallet,$afterCharge) {
        $authWallet->update([
            'balance'   => $afterCharge,
        ]);
    }
}
