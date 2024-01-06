<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Models\Admin\Currency;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use App\Traits\PaymentGateway\Manual;
use App\Traits\PaymentGateway\Stripe;
use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Http\Helpers\PaymentGateway as PaymentGatewayHelper;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Traits\PaymentGateway\FlutterwaveTrait;
use App\Traits\PaymentGateway\RazorTrait;
use App\Traits\PaymentGateway\SslcommerzTrait;
use Illuminate\Support\Facades\Auth;

class AddMoneyController extends Controller
{
    use Stripe,Manual,FlutterwaveTrait,RazorTrait,SslcommerzTrait;

    public function index() {
        $page_title = "Add Money";
        $user_wallets = UserWallet::auth()->get();
        $user_currencies = Currency::whereIn('id',$user_wallets->pluck('id')->toArray())->get();

        $payment_gateways_currencies = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::add_money_slug());
            $gateway->where('status', 1);
        })->get();
        $transactions = Transaction::auth()->addMoney()->latest()->take(5)->get();
        return view('user.sections.add-money.index',compact("page_title","payment_gateways_currencies","transactions"));
    }

    public function submit(Request $request) {

        try{
            $instance = PaymentGatewayHelper::init($request->all())->gateway()->render();
        }catch(Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
        return $instance;
    }

    public function success(Request $request, $gateway){
        $requestData = $request->all();
        $token = $requestData['token'] ?? "";
        $checkTempData = TemporaryData::where("type",$gateway)->where("identifier",$token)->first();
        if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction faild. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();

        try{
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive();
        }catch(Exception $e) {

            return back()->with(['error' => [$e->getMessage()]]);
        }
        return redirect()->route("user.add.money.index")->with(['success' => ['Successfully added money']]);
    }

    public function cancel(Request $request, $gateway) {
        $token = session()->get('identifier');
        if( $token){
            TemporaryData::where("identifier",$token)->delete();
        }

        return redirect()->route('user.add.money.index');
    }

    //stripe success
    public function stripePaymentSuccess($trx){
        $token = $trx;
        $checkTempData = TemporaryData::where("type",PaymentGatewayConst::STRIPE)->where("identifier",$token)->first();
        if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();

        try{
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('stripe');
        }catch(Exception $e) {
            return back()->with(['error' => ["Something Is Wrong..."]]);
        }
        return redirect()->route("user.add.money.index")->with(['success' => ['Successfully Added Money']]);

    }

    public function manualPayment(){
        $tempData = Session::get('identifier');
        $hasData = TemporaryData::where('identifier', $tempData)->first();
        $gateway = PaymentGateway::manual()->where('slug',PaymentGatewayConst::add_money_slug())->where('id',$hasData->data->gateway)->first();
        $page_title = "Manual Payment Via".' '.$gateway->name;
        if(!$hasData){
            return redirect()->route('user.add.money.index');
        }
        return view('user.sections.add-money.manual.payment_confirmation',compact("page_title","hasData",'gateway'));
    }

    public function flutterwaveCallback()
    {

        $status = request()->status;


        //if payment is successful
        if ($status ==  'successful') {

            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $requestData = request()->tx_ref;
            $token = $requestData;

            $checkTempData = TemporaryData::where("type",'flutterwave')->where("identifier",$token)->first();

            if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);

            $checkTempData = $checkTempData->toArray();

            try{
                PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('flutterWave');
            }catch(Exception $e) {
                return back()->with(['error' => [$e->getMessage()]]);
            }
            return redirect()->route("user.add.money.index")->with(['success' => ['Successfully added money']]);

        }
        elseif ($status ==  'cancelled'){
            return redirect()->route('user.add.money.index')->with(['error' => ['Add money cancelled']]);
        }
        else{
            return redirect()->route('user.add.money.index')->with(['error' => ['Transaction failed']]);
        }
    }

    public function razorCallback()
    {
        $request_data = request()->all();
        //if payment is successful
        if ($request_data['razorpay_payment_link_status'] ==  'paid') {
            $token = $request_data['razorpay_payment_link_reference_id'];

            $checkTempData = TemporaryData::where("type",PaymentGatewayConst::RAZORPAY)->where("identifier",$token)->first();
            if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
            $checkTempData = $checkTempData->toArray();
            try{
                PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('razorpay');
            }catch(Exception $e) {
                return back()->with(['error' => [$e->getMessage()]]);
            }
            return redirect()->route("user.add.money.index")->with(['success' => ['Successfully added money']]);

        }
        else{
            return redirect()->route('user.add.money.index')->with(['error' => ['Transaction failed']]);
        }
    }

     //sslcommerz success
     public function sllCommerzSuccess(Request $request){
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type",PaymentGatewayConst::SSLCOMMERZ)->where("identifier",$token)->first();
        if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;

        $user = Auth::guard($creator_guard)->loginUsingId($creator_id);
        if( $data['status'] != "VALID"){
            return redirect()->route("user.add.money.index")->with(['error' => ['Added Money Failed']]);
        }
        try{
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('sslcommerz');
        }catch(Exception $e) {
            return back()->with(['error' => ["Something Is Wrong..."]]);
        }
        return redirect()->route("user.add.money.index")->with(['success' => ['Successfully Added Money']]);
    }
    //sslCommerz fails
    public function sllCommerzFails(Request $request){
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type",PaymentGatewayConst::SSLCOMMERZ)->where("identifier",$token)->first();
        if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;
        $user = Auth::guard($creator_guard)->loginUsingId($creator_id);
        if( $data['status'] == "FAILED"){
            TemporaryData::destroy($checkTempData['id']);
            return redirect()->route("user.add.money.index")->with(['error' => ['Added Money Failed']]);
        }

    }
    //sslCommerz canceled
    public function sllCommerzCancel(Request $request){
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type",PaymentGatewayConst::SSLCOMMERZ)->where("identifier",$token)->first();
        if(!$checkTempData) return redirect()->route('user.add.money.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;
        $user = Auth::guard($creator_guard)->loginUsingId($creator_id);
        if( $data['status'] != "VALID"){
            TemporaryData::destroy($checkTempData['id']);
            return redirect()->route("user.add.money.index")->with(['error' => ['Added Money Canceled']]);
        }

    }
}


