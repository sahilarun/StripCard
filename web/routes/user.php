<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\Admin\BasicSettingsProvider;
use Pusher\PushNotifications\PushNotifications;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AddMoneyController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\AuthorizationController;
use App\Http\Controllers\User\StripeVirtualController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\User\TransferMoneyController;
use App\Http\Controllers\User\WithdrawController;

Route::prefix("user")->name("user.")->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('dashboard','index')->name('dashboard');
        Route::post('logout','logout')->name('logout');
        Route::delete('delete/account','deleteAccount')->name('delete.account')->middleware('app.mode');
    });
    Route::controller(ProfileController::class)->prefix("profile")->name("profile.")->group(function(){
        Route::get('/','index')->name('index');
        Route::put('update','update')->name('update')->middleware('app.mode');
        Route::get('change/password','changePassword')->name('change.password')->middleware('app.mode');
        Route::put('password/update','passwordUpdate')->name('password.update')->middleware('app.mode');
    });
    //Transfer  Money
    Route::controller(TransferMoneyController::class)->prefix('transfer-money')->name('transfer.money.')->middleware('kyc.verification.guard')->group(function(){
        Route::get('/','index')->name('index');
        Route::post('confirmed','confirmed')->name('confirmed');
        Route::post('user/exist','checkUser')->name('check.exist');
    });
    //add money
    Route::controller(AddMoneyController::class)->prefix("add-money")->name("add.money.")->group(function(){
        Route::get('/','index')->name("index");
        Route::post('submit','submit')->name('submit');
        //paypal
        Route::get('success/response/{gateway}','success')->name('payment.success');
        Route::get("cancel/response/{gateway}",'cancel')->name('payment.cancel');
        //stripe
        Route::get('stripe/payment/success/{trx}','stripePaymentSuccess')->name('stripe.payment.success');
        //manual gateway
        Route::get('manual/payment','manualPayment')->name('manual.payment');
        Route::post('manual/payment/confirmed','manualPaymentConfirmed')->name('manual.payment.confirmed');
        //flutterwave
        Route::get('flutterwave/callback', 'flutterwaveCallback')->name('flutterwave.callback');
        //razorpay
        Route::get('razor/callback', 'razorCallback')->name('razor.callback');

    });
    //withdraw money
    Route::controller(WithdrawController::class)->prefix('withdraw')->name('withdraw.')->middleware('kyc.verification.guard')->group(function(){
        Route::get('/','index')->name('index');
        Route::post('insert','paymentInsert')->name('submit');
        Route::get('preview','preview')->name('preview');
        Route::post('confirm','confirmMoneyOut')->name('confirm');

    });
    //virtual card stripe
     Route::middleware('virtual_card_method:stripe')->group(function(){
        Route::controller(StripeVirtualController::class)->prefix('stripe-virtual-card')->name('stripe.virtual.card.')->group(function(){
            Route::get('/','index')->name('index');
            Route::post('create','cardBuy')->name('create')->middleware('kyc.verification.guard');
            Route::get('details/{card_id}','cardDetails')->name('details');
            Route::get('transaction/{card_id}','cardTransaction')->name('transaction');
            Route::put('change/status','cardBlockUnBlock')->name('change.status');
            Route::post('get/sensitive/data','getSensitiveData')->name('sensitive.data');
        });
    });
    //transactions
    Route::controller(TransactionController::class)->prefix("transactions")->name("transactions.")->group(function(){
        Route::get('/{slug?}','index')->name('index')->whereIn('slug',['add-money','money-out','virtual-card','transfer-money','withdraw-money']);
        Route::post('search','search')->name('search');
    });
    //supports
    Route::controller(SupportTicketController::class)->prefix("support/ticket")->name("support.ticket.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('conversation/{encrypt_id}','conversation')->name('conversation');
        Route::post('message/send','messageSend')->name('messaage.send');
    });
    //kyc
    Route::controller(AuthorizationController::class)->prefix("authorize")->name('authorize.')->group(function(){
        Route::get('kyc','showKycFrom')->name('kyc');
        Route::post('kyc/submit','kycSubmit')->name('kyc.submit');
    });

});
Route::get('user/pusher/beams-auth', function (Request $request) {
    if(Auth::check() == false) {
        return response(['Inconsistent request'], 401);
    }
    $userID = Auth::user()->id;

    $basic_settings = BasicSettingsProvider::get();
    if(!$basic_settings) {
        return response('Basic setting not found!', 404);
    }

    $notification_config = $basic_settings->push_notification_config;

    if(!$notification_config) {
        return response('Notification configuration not found!', 404);
    }

    $instance_id    = $notification_config->instance_id ?? null;
    $primary_key    = $notification_config->primary_key ?? null;
    if($instance_id == null || $primary_key == null) {
        return response('Sorry! You have to configure first to send push notification.', 404);
    }
    $beamsClient = new PushNotifications(
        array(
            "instanceId" => $notification_config->instance_id,
            "secretKey" => $notification_config->primary_key,
        )
    );
    $publisherUserId = "user-".$userID;
    try{
        $beamsToken = $beamsClient->generateToken($publisherUserId);
    }catch(Exception $e) {
        return response(['Server Error. Faild to generate beams token.'], 500);
    }

    return response()->json($beamsToken);
})->name('user.pusher.beams.auth');

