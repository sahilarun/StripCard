<?php

namespace App\Http\Controllers\User\PaymentGateway;

use Exception;
use Stripe\Token;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StripeController extends Controller
{
    public function stripePayment(Request $request)
    {
        $request->merge(["cardNumber" => remove_spaces($request->cardNumber)]);
        $stipe = PaymentGateway::gateway('stripe')->first();
        $secret_key = $stipe->credentials[1]->value;
        $rules = [
            'cardNumber' => 'required|digits:16,16',
            'cardExpiry' => 'required',
            'cardCVC' => 'required',
        ];
        //Validation message
        $customMessage = [
            'cardNumber.required' => 'Card number is required',
            'cardExpiry.required' => 'Expiry date is required',
            'cardCVC.required' => 'CVC required'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessage);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $expirydate = explode("/", $_POST['cardExpiry']);
        $expiryMonth = trim($expirydate[0]);
        $expiryYear = trim($expirydate[1]);
        $amountConvertedToCents = round($request->total_amount * 2) * 100;
        Stripe::setApiKey($secret_key);
        $stripeToken = Token::create(array(
            "card" => array(
                "number" => $request->cardNumber,
                "exp_month" => $expiryMonth,
                "exp_year" => $expiryYear,
                "cvc" => $request->cvc
            )
        ));
        $payment = Charge::create([
            "currency" => $request->currency_code,
            "amount" => $amountConvertedToCents,
            "source" => $stripeToken,
            "description" => "Add Moeney",
        ]);
        if (isset($payment->id)) {
            $user_id = auth()->user()->id;
            $user_wallet = UserWallet::where('user_id', $user_id)->where('currency_code', $request->currency_code)->first();
            $paymentGateway = PaymentGateway::where('code', $request->gateway_code)->select('id')->first();
            DB::beginTransaction();
            try {
                #Start transaction
                $transaction                    = new Transaction();
                $transaction->type              = 'add-money';
                $transaction->trx_id            = Str::uuid();
                $transaction->amount            = $request->total_amount;
                $transaction->percent_charge    = $request->percent_charges;
                $transaction->fixed_charge      = $request->fixed_charge;
                $transaction->total_charge      = $request->total_charges;
                $transaction->total_payable     = $request->total_amount + $request->total_charges;
                $transaction->user_id           = $user_id;
                $transaction->user_wallet_id    = $user_wallet->id;
                $transaction->payment_gateway_id = $paymentGateway->id;
                $transaction->charge_status     = '+';
                $transaction->status            = 1;
                $transaction->currency_code     = $request->currency_code;
                $transaction->available_balance = $request->requested_amount + $user_wallet->balance;
                $transaction->save();
                $lastTransaction = DB::getPdo()->lastInsertId();
                if ($lastTransaction) {
                    #Create New Wallet for User
                    $updateWallet = UserWallet::where('id', $user_wallet->id)->first();
                    $updateWallet->user_id           = auth()->user()->id;
                    $updateWallet->currency_code     = $request->currency_code;;
                    $updateWallet->currency_id     = $user_wallet->currency_id;
                    if ($payment->paid == true) {
                        $updateWallet->balance += $request->requested_amount;
                    }
                    $updateWallet->update();
                }
                #Saved transaction
                DB::commit();
                return redirect('user/money/add')->with(['success' => ['Transaction successfull']]);
            } catch (Exception $e) {
                info($e);
                DB::rollback();
                return redirect('user/money/add')->with(['success' => ['Something wrong']]);
            }
        }
    }
}
