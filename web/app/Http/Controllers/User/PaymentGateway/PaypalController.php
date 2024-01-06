<?php

namespace App\Http\Controllers\User\PaymentGateway;

use Exception;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use App\Traits\PaymentGateway\PaypalTrait;
use App\Models\TemporaryData;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    use PaypalTrait;
    public $gateway;
    public $request;
    // Payment Success
    public function paymentSuccess(Request $request)
    {
        $temp_data = DB::table('temporary_datas')->where('identifier', $request->token)->first();
        $gateway = PaymentGateway::where('code', $temp_data->gateway_code)->first();
        if (!$gateway) {
            return redirect()->back()->with(['error' => ['Gateway not found.']]);
        }
        $provider = new PayPalClient;
        $payPalConfig = PaypalTrait::config($gateway, $temp_data);
        $provider->setApiCredentials($payPalConfig);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $response_data = [
                'gateway_id'            => $response['id'] ?? "",
                'gateway_trx'           => $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? "",
                'currency_code'         => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? "",
                'email'                 => $response['payer']['email_address'] ?? "",
                'payer'                 => $response['payer']['payer_id'] ?? "",
                'status'                => $response['status'] ?? "",
                'code'                  => null,
                'message'               => "Add money completed successfully!",
                'reference'             => null,
                'add_balance'           => true,
                'transaction_status'    => 1, // 1: Complete, 2: Pending, 3: Rejected
                'message_status'        => 'success',
            ];
            return $this->addMoneySuccess($response_data, $temp_data);
        } else {
            return redirect()->back()->with(['error', $response['message'] ?? 'Something went wrong.']);
        }
        return redirect()->back()->with(['error' => ['Something went wrong.']]);
    }

    # Add Money Success
    public function addMoneySuccess($response_data)
    {
        $user_id = auth()->user()->id;
        $temData = TemporaryData::where('identifier', $response_data['gateway_id'])->first();
        $user_wallet = UserWallet::where('user_id', $user_id)->where('currency_code', $temData->currency_code)->first();
        $paymentGateway = PaymentGateway::where('code', $temData['gateway_code'])->select('id')->first();
        $charge_obj = json_decode($temData['data']);

        $totalAmount = $charge_obj->charges->total_amount;
        $totalCharge = $charge_obj->charges->total_charges;
        DB::beginTransaction();
        try {
            #Start transaction
            $transaction                    = new Transaction();
            $transaction->type              = 'add-money';
            $transaction->trx_id            = Str::uuid();
            $transaction->amount            = $totalAmount;
            $transaction->percent_charge    = $charge_obj->charges->percent_charges;
            $transaction->fixed_charge      = $charge_obj->charges->fixed_charge;
            $transaction->total_charge      = $totalCharge;
            $transaction->total_payable     = $totalAmount + $totalCharge;
            $transaction->user_id           = $user_id;
            $transaction->user_wallet_id    = $user_wallet->id;
            $transaction->payment_gateway_id = $paymentGateway->id;
            $transaction->charge_status     = '+';
            $transaction->status            = $response_data['transaction_status'];
            $transaction->currency_code     = $temData->currency_code;
            $transaction->available_balance = $charge_obj->charges->requested_amount + $user_wallet->balance;
            $transaction->save();
            $lastTransaction = DB::getPdo()->lastInsertId();
            if ($lastTransaction) {
                #Create New Wallet for User
                $updateWallet = UserWallet::where('id', $user_wallet->id)->first();
                $updateWallet->user_id           = auth()->user()->id;
                $updateWallet->currency_code     = $temData->currency_code;
                $updateWallet->currency_id     = $user_wallet->currency_id;
                if ($response_data['add_balance'] == true) {
                    $updateWallet->balance += $charge_obj->charges->requested_amount;
                }
                $updateWallet->update();
            }
            #Saved transaction
            DB::table('temporary_datas')->where('identifier', '=', $response_data['gateway_id'])->delete();
            DB::commit();
            return redirect('user/money/add')->with(['success' => ['Transaction successfull']]);
        } catch (Exception $e) {
            info($e);
            DB::rollback();
            return redirect('user/money/add')->with(['success' => ['Something wrong']]);
        }
    }

    // Payment Cancel
    public function paymentCancel()
    {
        return redirect()->back()->with(['error' => ['Cancel']]);
    }
}
