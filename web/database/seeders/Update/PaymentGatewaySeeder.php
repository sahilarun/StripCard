<?php

namespace Database\Seeders\Update;

use Illuminate\Database\Seeder;
use App\Models\Admin\PaymentGateway;
use App\Models\Admin\PaymentGatewayCurrency;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //gateway
        $payment_gateways = array(
            array('id' => '10','slug' => 'money-out','code' => '145','type' => 'MANUAL','name' => 'StripCard(Manual)','title' => 'StripCard(Manual) Gateway','alias' => 'stripcardmanual','image' => '274b95fc-258a-445e-ad96-6d91783e6d9b.webp','credentials' => NULL,'supported_currencies' => '["USD"]','crypto' => '0','desc' => '<p>This is the manual withdraw gateway for StripCard, Please follow the withdraw instruction and sumit required information.</p>','input_fields' => '[{"type":"text","label":"Email","name":"email","required":true,"validation":{"max":"30","mimes":[],"min":"5","options":[],"required":true}},{"type":"text","label":"Card Number","name":"card_number","required":true,"validation":{"max":"30","mimes":[],"min":"16","options":[],"required":true}},{"type":"text","label":"Card Expiry","name":"card_expiry","required":true,"validation":{"max":"30","mimes":[],"min":"4","options":[],"required":true}},{"type":"text","label":"CVC","name":"cvc","required":true,"validation":{"max":"30","mimes":[],"min":"3","options":[],"required":true}}]','env' => NULL,'status' => '1','last_edit_by' => '1','created_at' => NULL,'updated_at' => '2023-10-03 13:34:59'),
            array('id' => '11','slug' => 'add-money','code' => '210','type' => 'AUTOMATIC','name' => 'SSLCommerz','title' => 'SSLCommerz Payment Gateway For Add Money','alias' => 'sslcommerz','image' => 'f4fe90e9-9b25-48b8-b3f5-9847cfbc6da7.webp','credentials' => '[{"label":"Store Id","placeholder":"Enter Store Id","name":"store-id","value":"appde6513b3970d62c"},{"label":"Store Password","placeholder":"Enter Store Password","name":"store-password","value":"appde6513b3970d62c@ssl"},{"label":"Sandbox Url","placeholder":"Enter Sandbox Url","name":"sandbox-url","value":"https:\\/\\/sandbox.sslcommerz.com"},{"label":"Live Url","placeholder":"Enter Live Url","name":"live-url","value":"https:\\/\\/securepay.sslcommerz.com"}]','supported_currencies' => '["BDT","EUR","GBP","AUD","USD","CAD"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'status' => '1','last_edit_by' => '1','created_at' => '2023-09-27 16:11:26','updated_at' => '2023-09-27 16:11:53','env' => 'SANDBOX'),
            array('id' => '12','slug' => 'add-money','code' => '200','type' => 'AUTOMATIC','name' => 'RazorPay','title' => 'Razor Pay Payment Gateway','alias' => 'razorpay','image' => '7f46e145-774e-41bf-9170-243605a5d4d0.webp','credentials' => '[{"label":"Public key","placeholder":"Enter Public key","name":"public-key","value":"rzp_test_B6FCT9ZBZylfoY"},{"label":"Secret Key","placeholder":"Enter Secret Key","name":"secret-key","value":"s4UYHtNwq5TkHSexU5Pnp1pm"}]','supported_currencies' => '["INR"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'status' => '1','last_edit_by' => '1','created_at' => '2023-08-23 13:21:55','updated_at' => '2023-08-23 13:23:20','env' => 'SANDBOX'),
            array('id' => '13','slug' => 'add-money','code' => '142','type' => 'AUTOMATIC','name' => 'Flutterwave','title' => 'Flutterwave Payement Gateway','alias' => 'flutterwave','image' => '137701d0-4e12-4a21-bc63-cda5454c2476.webp','credentials' => '[{"label":"Encryption key","placeholder":"Enter Encryption key","name":"encryption-key","value":"FLWSECK_TEST27bee2235efd"},{"label":"Secret key","placeholder":"Enter Secret key","name":"secret-key","value":"FLWSECK_TEST-da35e3dbd28be1e7dc5d5f3519e2ebef-X"},{"label":"Public key","placeholder":"Enter Public key","name":"public-key","value":"FLWPUBK_TEST-e0bc02a00395b938a4a2bed65e1bc94f-X"}]','supported_currencies' => '["AED", "ARS", "AUD", "CAD", "CHF", "CZK", "ETB", "EUR", "GBP", "GHS", "ILS", "INR", "JPY", "KES", "MAD", "MUR", "MYR", "NGN", "NOK", "NZD", "PEN", "PLN", "RUB", "RWF", "SAR", "SEK", "SGD", "SLL", "TZS", "UGX", "USD", "XAF", "XOF", "ZAR", "ZMK", "ZMW", "MWK"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => NULL,'status' => '1','last_edit_by' => '1','created_at' => '2023-05-25 11:40:27','updated_at' => '2023-05-30 18:42:59'),
        );
        PaymentGateway::insert($payment_gateways);

        //gateway currency
        $payment_gateway_currencies = array(
            array('payment_gateway_id' => '10','name' => 'StripCard(Manual) USD','alias' => 'stripcardmanual-usd-money-out','currency_code' => 'USD','currency_symbol' => '$','image' => NULL,'min_limit' => '1.00000000','max_limit' => '100.00000000','percent_charge' => '1.00000000','fixed_charge' => '1.00000000','rate' => '1.00000000','created_at' => '2023-10-03 13:15:44','updated_at' => '2023-10-03 13:34:59'),
            array('payment_gateway_id' => '11','name' => 'SSLCommerz BDT','alias' => 'add-money-sslcommerz-bdt-automatic','currency_code' => 'BDT','currency_symbol' => '৳','image' => '06f617aa-a336-4382-987e-ae632929bed1.webp','min_limit' => '100.00000000','max_limit' => '50000.00000000','percent_charge' => '0.00000000','fixed_charge' => '0.00000000','rate' => '110.64000000','created_at' => '2023-10-03 17:27:49','updated_at' => '2023-10-03 17:29:55'),
            array('payment_gateway_id' => '12','name' => 'RazorPay INR','alias' => 'add-money-razorpay-inr-automatic','currency_code' => 'INR','currency_symbol' => '₹','image' => '69b7df34-f1fb-4947-a6f5-e93b78648075.webp','min_limit' => '100.00000000','max_limit' => '100000.00000000','percent_charge' => '0.00000000','fixed_charge' => '1.00000000','rate' => '82.87000000','created_at' => '2023-10-03 17:28:26','updated_at' => '2023-10-03 17:28:26'),
            array('payment_gateway_id' => '13','name' => 'Flutterwave NGN','alias' => 'add-money-flutterwave-ngn-automatic','currency_code' => 'NGN','currency_symbol' => '₦','image' => '17fb91c7-a29c-486a-ac5f-ca8bc69a1bfe.webp','min_limit' => '1000.00000000','max_limit' => '10000.00000000','percent_charge' => '1.00000000','fixed_charge' => '0.00000000','rate' => '464.00000000','created_at' => '2023-10-03 17:29:06','updated_at' => '2023-10-03 17:29:06')
        );
        PaymentGatewayCurrency::insert($payment_gateway_currencies);

    }
}
