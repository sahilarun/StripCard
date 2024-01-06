<?php
namespace App\Http\Helpers;

use App\Constants\PaymentGatewayConst;
use App\Models\Admin\Currency;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Models\UserWallet;
use App\Traits\PaymentGateway\Paypal;
use App\Traits\PaymentGateway\Stripe;
use App\Traits\PaymentGateway\Manual;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Traits\PaymentGateway\FlutterwaveTrait;
use App\Traits\PaymentGateway\RazorTrait;
use App\Traits\PaymentGateway\SslcommerzTrait;

class PaymentGateway {

    use Paypal,Stripe,Manual,FlutterwaveTrait,RazorTrait,SslcommerzTrait;

    protected $request_data;
    protected $output;
    protected $currency_input_name = "currency";
    protected $amount_input = "amount";

    public function __construct(array $request_data)
    {
        $this->request_data = $request_data;
    }

    public static function init(array $data) {
        return new PaymentGateway($data);
    }

    public function gateway() {
        $request_data = $this->request_data;
        if(empty($request_data)) throw new Exception("Gateway Information is not available. Please provide payment gateway currency alias");
        $validated = $this->validator($request_data)->validate();
        $gateway_currency = PaymentGatewayCurrency::where("alias",$validated[$this->currency_input_name])->first();

        if(!$gateway_currency || !$gateway_currency->gateway) {
            throw ValidationException::withMessages([
                $this->currency_input_name = "Gateway not available",
            ]);
        }
        $defualt_currency = Currency::default();

        $user_wallet = UserWallet::auth()->where('currency_id', $defualt_currency->id)->first();

        if(!$user_wallet) {
            throw ValidationException::withMessages([
                $this->currency_input_name = "User wallet not found!",
            ]);
        }


        if($gateway_currency->gateway->isAutomatic()) {
            $this->output['gateway']    = $gateway_currency->gateway;
            $this->output['currency']   = $gateway_currency;
            $this->output['amount']     = $this->amount();
            $this->output['wallet']     = $user_wallet;
            $this->output['distribute'] = $this->gatewayDistribute($gateway_currency->gateway);
        }elseif($gateway_currency->gateway->isManual()){
            $this->output['gateway']    = $gateway_currency->gateway;
            $this->output['currency']   = $gateway_currency;
            $this->output['amount']     = $this->amount();
            $this->output['wallet']     = $user_wallet;
            $this->output['distribute'] = $this->gatewayDistribute($gateway_currency->gateway);
        }

        // limit validation
        $this->limitValidation($this->output);

        return $this;
    }

    public function validator($data) {
        return Validator::make($data,[
            $this->currency_input_name  => "required|exists:payment_gateway_currencies,alias",
            $this->amount_input         => "required|numeric",
        ]);
    }

    public function limitValidation($output) {

        $gateway_currency = $output['currency'];
        $requested_amount = $output['amount']->requested_amount;
        if($requested_amount < ($gateway_currency->min_limit/$gateway_currency->rate) || $requested_amount > ($gateway_currency->max_limit/$gateway_currency->rate)) {
            throw ValidationException::withMessages([
                $this->amount_input = "Please follow the transaction limit",
            ]);
        }
    }

    public function get() {
        return $this->output;
    }

    public function gatewayDistribute($gateway = null) {

        if(!$gateway) $gateway = $this->output['gateway'];
        $alias = Str::lower($gateway->alias);
        if($gateway->type == PaymentGatewayConst::AUTOMATIC){
            $method = PaymentGatewayConst::register($alias);
        }elseif($gateway->type == PaymentGatewayConst::MANUAL){
            $method = PaymentGatewayConst::register(strtolower($gateway->type));
        }

        if(method_exists($this,$method)) {
            return $method;
        }
        return throw new Exception("Gateway(".$gateway->name.") Trait or Method (".$method."()) does not exists");
    }

    public function amount() {
        $currency = $this->output['currency'] ?? null;
        if(!$currency) throw new Exception("Gateway currency not found");
        return $this->chargeCalculate($currency);
    }

    public function chargeCalculate($currency,$receiver_currency = null) {

        $amount = $this->request_data[$this->amount_input];
        $sender_currency_rate = $currency->rate;

        ($sender_currency_rate == "" || $sender_currency_rate == null) ? $sender_currency_rate = 0 : $sender_currency_rate;
        ($amount == "" || $amount == null) ? $amount : $amount;

        if($currency != null) {
            $fixed_charges = $currency->fixed_charge;
            $percent_charges = $currency->percent_charge;
        }else {
            $fixed_charges = 0;
            $percent_charges = 0;
        }

        $fixed_charge_calc = ($sender_currency_rate * $fixed_charges);
        $percent_charge_calc = $sender_currency_rate * (($amount / 100 ) * $percent_charges );

        $total_charge = $fixed_charge_calc + $percent_charge_calc;

        if($receiver_currency) {
            $receiver_currency_rate = $receiver_currency->rate;
            ($receiver_currency_rate == "" || $receiver_currency_rate == null) ? $receiver_currency_rate = 0 : $receiver_currency_rate;
            $exchange_rate = ($receiver_currency_rate / $sender_currency_rate);
            $will_get = ($amount * $exchange_rate);

            $data = [
                'requested_amount'          => $amount,
                'sender_cur_code'           => $currency->currency_code,
                'sender_cur_rate'           => $sender_currency_rate ?? 0,
                'receiver_cur_code'         => $receiver_currency->currency_code,
                'receiver_cur_rate'         => $receiver_currency->rate ?? 0,
                'fixed_charge'              => $fixed_charge_calc,
                'percent_charge'            => $percent_charge_calc,
                'total_charge'              => $total_charge,
                'total_amount'              => $amount + $total_charge,
                'exchange_rate'             => $exchange_rate,
                'will_get'                  => $will_get,
                'default_currency'          => get_default_currency_code(),
            ];

        }else {
            $defualt_currency = Currency::default();
            $exchange_rate =  $defualt_currency->rate;
            $will_get = ($amount * $exchange_rate);
            $total_Amount = ($amount * $sender_currency_rate) + $total_charge;

            $data = [
                'requested_amount'          => $amount,
                'sender_cur_code'           => $currency->currency_code,
                'sender_cur_rate'           => $sender_currency_rate ?? 0,
                'fixed_charge'              => $fixed_charge_calc,
                'percent_charge'            => $percent_charge_calc,
                'total_charge'              => $total_charge,
                'total_amount'              => $total_Amount,
                'exchange_rate'             => $exchange_rate,
                'will_get'                  => $will_get,
                'default_currency'          => get_default_currency_code(),
            ];
        }

        return (object) $data;
    }

    public function render() {
        $output = $this->output;

        if(!is_array($output)) throw new Exception("Render Faild! Please call with valid gateway/credentials");

        $common_keys = ['gateway','currency','amount','distribute'];
        foreach($output as $key => $item) {
            if(!array_key_exists($key,$common_keys)) {
                $this->gateway();
                break;
            }
        }

        $distributeMethod = $this->output['distribute'];
        return $this->$distributeMethod($output) ?? throw new Exception("Something went worng! Please try again.");
    }

    public function responseReceive( $type = null) {
        $tempData = $this->request_data;
        if(empty($tempData) || empty($tempData['type'])) throw new Exception('Transaction Failed. Record didn\'t saved properly. Please try again.');
        $method_name = $tempData['type']."Success";

        if($this->requestIsApiUser()) {
            $creator_table = $tempData['data']->creator_table ?? null;
            $creator_id = $tempData['data']->creator_id ?? null;
            $creator_guard = $tempData['data']->creator_guard ?? null;
            $api_authenticated_guards = PaymentGatewayConst::apiAuthenticateGuard();
            if(!array_key_exists($creator_guard,$api_authenticated_guards)) throw new Exception('Request user doesn\'t save properly. Please try again');
            if($creator_table == null || $creator_id == null || $creator_guard == null) throw new Exception('Request user doesn\'t save properly. Please try again');
            $creator = DB::table($creator_table)->where("id",$creator_id)->first();
            if(!$creator) throw new Exception("Request user doesn\'t save properly. Please try again");
            $api_user_login_guard = $api_authenticated_guards[$creator_guard];
            $this->output['api_login_guard'] = $api_user_login_guard;
            Auth::guard($api_user_login_guard)->loginUsingId($creator->id);
        }

        $currency_id = $tempData['data']->currency ?? "";
        $gateway_currency = PaymentGatewayCurrency::find($currency_id);
        if(!$gateway_currency) throw new Exception('Transaction Failed. Gateway currency not available.');
        $requested_amount = $tempData['data']->amount->requested_amount ?? 0;
        $validator_data = [
            $this->currency_input_name  => $gateway_currency->alias,
            $this->amount_input         => $requested_amount
        ];
        $this->request_data = $validator_data;
        $this->gateway();
        $this->output['tempData'] = $tempData;
       if($type == 'stripe'){
            if(method_exists(Stripe::class,$method_name)) {
                return $this->$method_name($this->output);
            }
        }elseif($type == 'razorpay'){
            if(method_exists(RazorTrait::class,$method_name)) {
                return $this->$method_name($this->output);
            }
        }elseif($type == 'sslcommerz'){
            if(method_exists(SslcommerzTrait::class,$method_name)) {
                return $this->$method_name($this->output);
            }
        }elseif($type == 'flutterWave'){
            if(method_exists(FlutterwaveTrait::class,$method_name)) {
                return $this->$method_name($this->output);
            }
        }else{
            if(method_exists(Paypal::class,$method_name)) {
                return $this->$method_name($this->output);
            }
        }
        throw new Exception("Response method ".$method_name."() does not exists.");
    }

    public function type($type) {
        $this->output['type']  = $type;
        return $this;
    }
    public function requestIsApiUser() {
        $request_source = request()->get('r-source');
        if($request_source != null && $request_source == PaymentGatewayConst::APP) return true;
        return false;
    }

}
