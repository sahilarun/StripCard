<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\Admin\BasicSettingsProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BroadcastingController extends Controller
{

    public function configUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'broadcast_method'      => 'required|string|in:pusher',

            'broadcast_app_id'      => 'required_if:broadcast_method,pusher|string|max:255',
            'broadcast_primary_key' => 'required_if:broadcast_method,pusher|string|max:255',
            'broadcast_secret_key'  => 'required_if:broadcast_method,pusher|string|max:255',
            'broadcast_cluster'     => 'required_if:broadcast_method,pusher|string|max:50',
        ]);

        $validated = $validator->validate();

        $validated = replace_array_key($validated,"broadcast_");

        $basic_setting = BasicSettingsProvider::get();

        try{
            $basic_setting->update([
                'broadcast_config'  => $validated,
            ]);

            modifyEnv([
                "BROADCAST_DRIVER"      => remove_spaces($validated['method']),
                "PUSHER_APP_ID"         => remove_spaces($validated['app_id']),
                "PUSHER_APP_KEY"        => remove_spaces($validated['primary_key']),
                "PUSHER_APP_SECRET"     => remove_spaces($validated['secret_key']),
                "PUSHER_APP_CLUSTER"    => remove_spaces($validated['cluster']),
            ]);
        }catch(Exception $e) {  
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Broadcast configuration updated successfully!']]);

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
