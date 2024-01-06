<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Response;
use App\Models\Admin\PaymentGatewayCurrency;
use Exception;

class PaymentGatewayCurrencyController extends Controller
{
    public function paymentGatewayCurrencyRemove(Request $request) {
        $validator = Validator::make($request->all(),[
            'data_target'       => 'required|numeric',
        ]);

        if($validator->stopOnFirstFailure()->fails()) {
            return Response::error($validator->errors());
        }

        $validated = $validator->validate();

        // find terget Item
        $gateway_currency = PaymentGatewayCurrency::find($validated['data_target']);
        if(!$gateway_currency) {
            $error = ['error' => ['Payment gateway currency not found!']];
            return Response::error($error,null,404);
        }

        try{
            if($gateway_currency->image != null) {
                $image_link     = get_files_path('payment-gateways') . "/" . $gateway_currency->image;
                delete_file($image_link);
            }
            $gateway_currency->delete();
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng! Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Payment gateway currency deleted successfully!']];
        return Response::success($success);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
