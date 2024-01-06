<?php
namespace App\Constants;
use Illuminate\Support\Str;

class PaymentGatewayConst {

    const AUTOMATIC = "AUTOMATIC";
    const MANUAL    = "MANUAL";
    const ADDMONEY  = "Add Money";
    const MONEYOUT  = "Money Out";
    const ACTIVE    =  true;

    const ENV_SANDBOX       = "SANDBOX";
    const ENV_PRODUCTION    = "PRODUCTION";

    const TYPEADDMONEY      = "ADD-MONEY";
    const WITHDRAWMONEY     = "WITHDRAW-MONEY";
    const TYPEMONEYOUT      = "MONEY-OUT";
    const TYPECOMMISSION    = "COMMISSION";
    const TYPEBONUS         = "BONUS";
    const TYPETRANSFERMONEY = "TRANSFER-MONEY";
    const TYPEMONEYEXCHANGE = "MONEY-EXCHANGE";
    const BILLPAY = "BILL-PAY";
    const MOBILETOPUP = "MOBILE-TOPUP";
    const VIRTUALCARD = "VIRTUAL-CARD";
    const CARDBUY = "CARD-BUY";
    const CARDFUND = "CARD-FUND";
    const CARDWITHDRAW = "CARD-WITHDRAW";
    const TYPEADDSUBTRACTBALANCE = "ADD-SUBTRACT-BALANCE";

    const STATUSSUCCESS     = 1;
    const STATUSPENDING     = 2;
    const STATUSHOLD        = 3;
    const STATUSREJECTED    = 4;

    const PAYPAL = 'paypal';
    const FLUTTER_WAVE = 'flutterwave';
    const RAZORPAY = 'razorpay';
    const SSLCOMMERZ = 'sslcommerz';

    const STRIPE = 'stripe';
    const MANUA_GATEWAY = 'manual';


    const SEND = "SEND";
    const RECEIVED = "RECEIVED";

    public static function add_money_slug() {
        return Str::slug(self::ADDMONEY);
    }


    public static function money_out_slug() {
        return Str::slug(self::MONEYOUT);
    }

    public static function register($alias = null) {
        $gateway_alias  = [
            self::PAYPAL        => "paypalInit",
            self::STRIPE        => "stripeInit",
            self::FLUTTER_WAVE => 'flutterwaveInit',
            self::RAZORPAY => 'razorInit',
            self::MANUA_GATEWAY => "manualInit",
            self::SSLCOMMERZ => 'sslcommerzInit'
        ];

        if($alias == null) {
            return $gateway_alias;
        }

        if(array_key_exists($alias,$gateway_alias)) {
            return $gateway_alias[$alias];
        }
        return "init";
    }
    const APP       = "APP";
    public static function apiAuthenticateGuard() {
            return [
                'api'   => 'web',
            ];
    }
}
