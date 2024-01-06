<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SetupKyc;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Response;

class SetupKycController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Setup KYC";
        $kycs = SetupKyc::orderByDesc('id')->get();
        return view('admin.sections.setup-kyc.index',compact(
            'page_title',
            'kycs',
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
    public function edit($slug)
    {
        $page_title = "KYC Data Form";
        $kyc = SetupKyc::where('slug',$slug)->firstOrfail();
        return view('admin.sections.setup-kyc.edit',compact(
            'page_title',
            'kyc',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // find kyc
        $find = Validator::make(['slug' => $slug],[
            'slug'          => 'required|string|exists:setup_kycs',
        ],[
            'slug'          => "Invalid KYC Or KYC not found!",
        ])->validate();

        // Form Data Validate
        $validator = Validator::make($request->all(),[
            'label'                 => 'nullable|array',
            'label.*'               => 'nullable|string|max:50',
            'input_type'            => 'nullable|array',
            'input_type.*'          => 'nullable|string|max:20',
            'min_char'              => 'nullable|array',
            'min_char.*'            => 'nullable|numeric',
            'max_char'              => 'nullable|array',
            'max_char.*'            => 'nullable|numeric',
            'field_necessity'       => 'nullable|array',
            'field_necessity.*'     => 'nullable|string|max:20',
            'file_extensions'       => 'nullable|array',
            'file_extensions.*'     => 'nullable|string|max:255',
            'file_max_size'         => 'nullable|array',
            'file_max_size.*'       => 'nullable|numeric',
            'select_options'        => 'nullable|array',
            'select_options.*'      => 'nullable|string|max:60',
        ]);

        $validated = $validator->validate();

        $validated['fields'] = decorate_input_fields($validated);

        $validated = Arr::except($validated,['label','input_type','min_char','max_char','field_necessity','file_extensions','file_max_size','select_options']);
        $validated['last_edit_by']  = Auth::user()->id;

        try{
            SetupKyc::where('slug',$slug)->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }


        return back()->with(['success' => ['Information updated successfully!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * Function for update KYC status
     * @param  \Illuminate\Http\Request  $request
     */
    public function statusUpdate(Request $request) {

        $validator = Validator::make($request->all(),[
            'data_target'       => 'required|numeric',
            'status'            => 'required|integer',
        ]);

        if($validator->stopOnFirstFailure()->fails()) {
            return Response::error($validator->errors());
        }

        $validated = $validator->validate();

        $status = [
            0 => true,
            1 => false,
        ];

        // find target Item
        $kyc = SetupKyc::find($validated['data_target']);
        if(!$kyc) {
            $error = ['error' => ['Invalid KYC or KYC not found!']];
            return Response::error($error,null,404);
        }

        try{
            $kyc->update([
                'status'        => $status[$validated['status']],
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng! Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['KYC status updated successfully!']];
        return Response::success($success);

    }
}
