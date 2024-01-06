<?php

namespace App\Http\Controllers\User;

use App\Constants\PaymentGatewayConst;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Response;
use Exception;

class TransactionController extends Controller
{

    public function slugValue($slug) {
        $values =  [
            'add-money'         => PaymentGatewayConst::TYPEADDMONEY,
            'money-out'         => PaymentGatewayConst::TYPEMONEYOUT,
            'transfer-money'    => PaymentGatewayConst::TYPETRANSFERMONEY,
            'money-exchange'    => PaymentGatewayConst::TYPEMONEYEXCHANGE,
            'bill-pay'    => PaymentGatewayConst::BILLPAY,
            'mobile-topup'    => PaymentGatewayConst::MOBILETOPUP,
            'virtual-card'    => PaymentGatewayConst::VIRTUALCARD,
            'withdraw-money'    => PaymentGatewayConst::WITHDRAWMONEY,

        ];

        if(!array_key_exists($slug,$values)) return abort(404);
        return $values[$slug];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null) {
        if($slug != null){
            $transactions = Transaction::auth()->where("type",$this->slugValue($slug))->orderByDesc("id")->paginate(12);
            $page_title = ucwords(remove_speacial_char($slug," ")) . " Log";
        }else {
            $transactions = Transaction::auth()->orderByDesc("id")->paginate(12);
            $page_title = "Transaction Log";
        }

        return view('user.sections.transaction.index',compact("page_title","transactions"));
    }


    public function search(Request $request) {
        // return print_r($request->all());
        $validator = Validator::make($request->all(),[
            'text'  => 'required|string',
        ]);

        if($validator->fails()) {
            return Response::error($validator->errors(),null,400);
        }

        $validated = $validator->validate();

        try{
            $transactions = Transaction::auth()->search($validated['text'])->take(10)->get();
        }catch(Exception $e){
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error,null,500);
        }

        return view('user.components.search.transaction-log',compact('transactions'));
    }
}
