<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\TransactionSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrxSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Fees & Charges";
        $transaction_charges = TransactionSetting::all();
        return view('admin.sections.trx-settings.index',compact(
            'page_title',
            'transaction_charges'
        ));
    }

    /**
     * Update transaction charges
     * @param Request closer
     * @return back view
     */
    public function trxChargeUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'slug'                              => 'required|string',
            $request->slug.'_fixed_charge'      => 'required|numeric',
            $request->slug.'_percent_charge'    => 'required|numeric',
            $request->slug.'_min_limit'         => 'required|numeric',
            $request->slug.'_max_limit'         => 'required|numeric',
            $request->slug.'_daily_limit'       => 'sometimes|required|numeric',
            $request->slug.'_monthly_limit'     => 'sometimes|required|numeric',
        ]);
        $validated = $validator->validate();

        $transaction_setting = TransactionSetting::where('slug',$request->slug)->first();

        if(!$transaction_setting) return back()->with(['error' => ['Transaction charge not found!']]);
        $validated = replace_array_key($validated,$request->slug."_");

        try{
            $transaction_setting->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ["Something went worng! Please try again."]]);
        }

        return back()->with(['success' => ['Charge Updated Successfully!']]);

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
