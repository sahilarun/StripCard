<?php

namespace App\Traits\PaymentGateway;

use App\Models\TemporaryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

trait PaypalTrait
{
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public static function config($gateway, $request)
    {
        $credentials = $gateway->credentials;
        $config = [
            'mode'    => $credentials->mode->value ?? 'sandbox',
            'sandbox' => [
                'client_id'         => $credentials[1]->value,
                'client_secret'     => $credentials[0]->value,
                'app_id'            => "APP-80W284485P519543T",
            ],
            'live' => [
                'client_id'         => $credentials[1]->value,
                'client_secret'     => $credentials[0]->value,
                'app_id'            => "",
            ],
            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => $request->currency_code ?? "",
            'notify_url'     => "", // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];
        return $config;
    }

    public static function initialize($config, $request)
    {
        $data = $request->all();
        $pmntGateway = DB::table('payment_gateways')->select('id', 'code', 'slug')->where('code', '=', $data['payment_gateway'])->where('status', '=', 1)->first();
        $add_money_charges = DB::table('payment_gateway_currencies')->where('payment_gateway_id', '=', $pmntGateway->id)->where('currency_code', '=', $data['currency_code'])->first();
        $charges = addMoneyChargeCalc($data['amount'], $add_money_charges);
        $data["charges"] = $charges;
        $provider = new PayPalClient;
        $provider->setApiCredentials($config);
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.money.payment.success'),
                "cancel_url" => route('user.money.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $data['currency_code'],
                        "value" => $data['amount'] + $charges->total_charges
                    ]
                ]
            ]
        ]);
        // dd($response);
        # Temporary Data Insert
        $temp = new TemporaryData();
        $temp->type = 'payment-gateway';
        $temp->identifier = $response['id'];
        $temp->gateway_code =   $data['payment_gateway'];
        $temp->currency_code =    $data['currency_code'];
        $temp->data =   json_encode($data);
        $temp->save();
        $temp_data = DB::table('temporary_datas')->where('identifier', '=' , $response['id'])->where('type', '=', 'payment-gateway')->first();
        # Temporary data end
        if (isset($temp_data->identifier) && $temp_data->identifier != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->back()->with('error', ['Something went wrong']);
        } else {
            return redirect()->back()->withInput()->with(['error', ['error', $response['message'] ?? 'Something went wrong.']]);
        }
        return redirect()->back()->with('error', ['Something went wrong']);
    }
}
