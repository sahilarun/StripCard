<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteSections;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CookieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "GDPR Cookie";
        $site_cookie = SiteSections::siteCookie();

        return view('admin.sections.cookie.index',compact(
            'page_title',
            'site_cookie',
        ));
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
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'status'    => 'required|numeric',
            'link'      => 'required|string',
            'desc'      => 'required|string|max:50000',
        ]);

        $validated = $validator->validate();
        $type = 'site_cookie';

        $status = [
            '0'     => false,
            '1'     => true,
        ];
        $validated['status'] = $status[$validated['status']];

        // Insert bata into batabase
        try{
            SiteSections::updateOrCreate(['key' => $type],['key' => $type , 'value' => $validated, 'status' => $validated['status']]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Cookie information updated successfully!']]);
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
