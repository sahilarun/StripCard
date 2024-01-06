<?php

namespace App\Traits\PaymentGateway;

use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Helpers\Api\Helpers;
use App\Models\Admin\AdminNotification;
use App\Models\TemporaryData;
use App\Models\UserNotification;
use App\Notifications\User\AddMoney\ApprovedMail;
use App\Providers\Admin\BasicSettingsProvider;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use App\Events\User\NotificationEvent as UserNotificationEvent;

trait RazorTrait
{
    public function razorInit($output = null) {
        if(!$output) $output = $this->output;
        $credentials = $this->getCredentials($output);
        $api_key = $credentials->public_key;
        $api_secret = $credentials->secret_key;
        $amount = $output['amount']->total_amount ? number_format($output['amount']->total_amount,2,'.','') : 0;
        if(auth()->guard(get_auth_guard())->check()){
            $user = auth()->guard(get_auth_guard())->user();
            $user_email = $user->email;
            $user_phone = $user->full_mobile ?? '';
            $user_name = $user->firstname.' '.$user->lastname ?? '';
        }
        $return_url = route('user.add.money.razor.callback');
        $payment_link = "https://api.razorpay.com/v1/payment_links";

        // Enter the details of the payment
        $data = array(
            "amount" => $amount * 100,
            "currency" => $output['amount']->sender_cur_code,
            "accept_partial" => false,
            "first_min_partial_amount" => 100,
            "reference_id" =>getTrxNum(),
            "description" => "Payment For QRPay Add Balance",
            "customer" => array(
                "name" => $user_name ,
                "contact" => $user_phone,
                "email" =>  $user_email
            ),
            "notify" => array(
                "sms" => true,
                "email" => true
            ),
            "reminder_enable" => true,
            "notes" => array(
                "policy_name"=> "QRPay"
            ),
            "callback_url"=> $return_url,
            "callback_method"=> "get"
        );

        $payment_data_string = json_encode($data);
        $payment_ch = curl_init($payment_link);
        curl_setopt($payment_ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($payment_ch, CURLOPT_POSTFIELDS, $payment_data_string);
        curl_setopt($payment_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($payment_ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($api_key . ':' . $api_secret)
        ));

        $payment_response = curl_exec($payment_ch);
        $payment_data = json_decode($payment_response, true);
        if(isset($payment_data['error'])){
            throw new Exception($payment_data['error']['description']);
        }
        $this->razorJunkInsert($data);
        $payment_url = $payment_data['short_url'];
        return redirect($payment_url);
    }
     // Get Flutter wave credentials
     public function getCredentials($output) {
        $gateway = $output['gateway'] ?? null;
        if(!$gateway) throw new Exception("Payment gateway not available");

        $public_key_sample = ['api key','api_key','client id','primary key', 'public key'];
        $secret_key_sample = ['client_secret','client secret','secret','secret key','secret id'];

        $public_key = '';
        $outer_break = false;

        foreach($public_key_sample as $item) {
            if($outer_break == true) {
                break;
            }
            $modify_item = $this->flutterwavePlainText($item);
            foreach($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->flutterwavePlainText($label);
                if($label == $modify_item) {
                    $public_key = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        $secret_key = '';
        $outer_break = false;
        foreach($secret_key_sample as $item) {
            if($outer_break == true) {
                break;
            }
            $modify_item = $this->flutterwavePlainText($item);
            foreach($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->flutterwavePlainText($label);

                if($label == $modify_item) {
                    $secret_key = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        $encryption_key = '';
        $outer_break = false;

        return (object) [
            'public_key'     => $public_key,
            'secret_key'     => $secret_key,
        ];

    }
    public function razorJunkInsert($response) {
        $output = $this->output;
        $user = auth()->guard(get_auth_guard())->user();
        $creator_table = $creator_id = $wallet_table = $wallet_id = null;

        $creator_table = auth()->guard(get_auth_guard())->user()->getTable();
        $creator_id = auth()->guard(get_auth_guard())->user()->id;
        $wallet_table = $output['wallet']->getTable();
        $wallet_id = $output['wallet']->id;

            $data = [
                'gateway'      => $output['gateway']->id,
                'currency'     => $output['currency']->id,
                'amount'       => json_decode(json_encode($output['amount']),true),
                'response'     => $response,
                'wallet_table'  => $wallet_table,
                'wallet_id'     => $wallet_id,
                'creator_table' => $creator_table,
                'creator_id'    => $creator_id,
                'creator_guard' => get_auth_guard(),
            ];


        Session::put('identifier',$response['reference_id']);
        Session::put('output',$output);

        return TemporaryData::create([
            'type'          => PaymentGatewayConst::RAZORPAY,
            'identifier'    => $response['reference_id'],
            'data'          => $data,
        ]);
    }
    public function razorpaySuccess($output = null) {
        if(!$output) $output = $this->output;
        $token = $this->output['tempData']['identifier'] ?? "";
        if(empty($token)) throw new Exception('Transaction Failed. Record didn\'t saved properly. Please try again.');
        return $this->createTransactionRazor($output);
    }
    public function createTransactionRazor($output) {
        $basic_setting = BasicSettingsProvider::get();
        $user = auth()->user();
        $trx_id = 'AM'.getTrxNum();
        $inserted_id = $this->insertRecordRazor($output,$trx_id);
        $this->insertChargesRazor($output,$inserted_id);
        $this->insertDeviceRazor($output,$inserted_id);
        $this->removeTempDataRazor($output);
        if($this->requestIsApiUser()) {
            // logout user
            $api_user_login_guard = $this->output['api_login_guard'] ?? null;
            if($api_user_login_guard != null) {
                auth()->guard($api_user_login_guard)->logout();
            }
        }
        if( $basic_setting->email_notification == true){
            $user->notify(new ApprovedMail($user,$output,$trx_id));
        }

    }

    public function insertRecordRazor($output,$trx_id) {
        $token = $this->output['tempData']['identifier'] ?? "";
        DB::beginTransaction();
        try{
            if(Auth::guard(get_auth_guard())->check()){
                $user_id = auth()->guard(get_auth_guard())->user()->id;
            }
                // Add money
                $trx_id = $trx_id??'AM'.getTrxNum();
                $id = DB::table("transactions")->insertGetId([
                    'user_id'                       => $user_id,
                    'user_wallet_id'                => $output['wallet']->id,
                    'payment_gateway_currency_id'   => $output['currency']->id,
                    'type'                          => $output['type'],
                    'trx_id'                        => $trx_id,
                    'request_amount'                => $output['amount']->requested_amount,
                    'payable'                       => $output['amount']->total_amount,
                    'available_balance'             => $output['wallet']->balance + $output['amount']->requested_amount,
                    'remark'                        => ucwords(remove_speacial_char($output['type']," ")) . " With " . $output['gateway']->name,
                    'details'                       => 'Razor Pay Payment Successful',
                    'status'                        => true,
                    'created_at'                    => now(),
                ]);
                $this->updateWalletBalanceRazor($output);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return $id;
    }
    public function updateWalletBalanceRazor($output) {
        $update_amount = $output['wallet']->balance + $output['amount']->requested_amount;
        $output['wallet']->update([
            'balance'   => $update_amount,
        ]);
    }

    public function insertChargesRazor($output,$id) {
        if(Auth::guard(get_auth_guard())->check()){
            $user = auth()->guard(get_auth_guard())->user();
        }
        DB::beginTransaction();
        try{
            DB::table('transaction_charges')->insert([
                'transaction_id'    => $id,
                'percent_charge'    => $output['amount']->percent_charge,
                'fixed_charge'      => $output['amount']->fixed_charge,
                'total_charge'      => $output['amount']->total_charge,
                'created_at'        => now(),
            ]);
            DB::commit();

            //notification
            $notification_content = [
                'title'         => "Add Money",
                'message'       => "Your Wallet (".$output['wallet']->currency->code.") balance  has been added ".$output['amount']->requested_amount.' '. $output['wallet']->currency->code,
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => get_image($user->image,'user-profile'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::BALANCE_ADDED,
                'user_id'  =>  auth()->user()->id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function insertDeviceRazor($output,$id) {
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

    public function removeTempDataRazor($output) {
        TemporaryData::where("identifier",$output['tempData']['identifier'])->delete();
    }


    // ********* For API **********
    public function razorInitApi($output = null) {
        if(!$output) $output = $this->output;
        $credentials = $this->getCredentials($output);
        $api_key = $credentials->public_key;
        $api_secret = $credentials->secret_key;
        $amount = $output['amount']->total_amount ? number_format($output['amount']->total_amount,2,'.','') : 0;
        if(auth()->guard(get_auth_guard())->check()){
            $user = auth()->guard(get_auth_guard())->user();
            $user_email = $user->email;
            $user_phone = $user->full_mobile ?? '';
            $user_name = $user->firstname.' '.$user->lastname ?? '';
        }

        $return_url = route('api.razor.callback', "r-source=".PaymentGatewayConst::APP);

        $payment_link = "https://api.razorpay.com/v1/payment_links";

        // Enter the details of the payment
        $data = array(
            "amount" => $amount * 100,
            "currency" => $output['amount']->sender_cur_code,
            "accept_partial" => false,
            "first_min_partial_amount" => 100,
            "reference_id" =>getTrxNum(),
            "description" => "Payment For QRPay Add Balance",
            "customer" => array(
                "name" => $user_name ,
                "contact" => $user_phone,
                "email" =>  $user_email
            ),
            "notify" => array(
                "sms" => true,
                "email" => true
            ),
            "reminder_enable" => true,
            "notes" => array(
                "policy_name"=> "QRPay"
            ),
            "callback_url"=> $return_url,
            "callback_method"=> "get"
        );

        $payment_data_string = json_encode($data);
        $payment_ch = curl_init($payment_link);
        curl_setopt($payment_ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($payment_ch, CURLOPT_POSTFIELDS, $payment_data_string);
        curl_setopt($payment_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($payment_ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($api_key . ':' . $api_secret)
        ));

        $payment_response = curl_exec($payment_ch);
        $payment_data = json_decode($payment_response, true);
        if(isset($payment_data['error'])){
            $message = ['error' => [$payment_data['error']['description']]];
            Helpers::error($message);
        }
        $this->razorJunkInsert($payment_data);
        $data['short_url'] = $payment_data['short_url'];
        return $data;
    }
}
