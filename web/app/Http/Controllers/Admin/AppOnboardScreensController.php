<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AppOnboardScreens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Response;

class AppOnboardScreensController extends Controller
{

    /**
     * Display The Onboard Screens Settings Page
     *
     * @return view
     */
    public function onboardScreens() {
        $page_title = "Onboard Screen";
        $onboard_screens = AppOnboardScreens::get();
        return view('admin.sections.app-settings.onboard-screens',compact(
            'page_title',
            'onboard_screens',
        ));
    }


    /**
     * Function for store new onboard screen record
     * @param closer
     */
    public function onboardScreenStore(Request $request) {
        $validator = Validator::make($request->all(),[
            'image'     => 'required|image|mimes:png,jpg,webp,svg,jpeg',
            'title'     => 'nullable|string|max:120',
            'sub_title' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','onboard-screen-add');
        }

        $validated = $validator->validate();
        $validated['last_edit_by']  = Auth::user()->id;

        if($request->hasFile('image')) {
            try{
                $image = get_files_from_fileholder($request,'image');
                $upload_image = upload_files_from_path_static($image,'app-images',null,true,true);
                $validated['image'] = $upload_image;
            }catch(Exception $e) {
                return back()->withErrors($validator)->withInput()->with('modal','onboard-screen-add');
            }
        }

        try{
            AppOnboardScreens::create($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Onboard Screen Added Successfully!']]);

    }


    /**
     * Function for update onboard screen status by AJUX request
     */
    public function onboardScreenStatusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'data_target'   => 'required|numeric',
            'status'        => 'required|numeric',
            'input_name'    => 'required|string',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }

        $validated = $validator->validate();

        $target_id = $validated['data_target'];

        $onboard_screen = AppOnboardScreens::find($target_id);
        if(!$onboard_screen) {
            $error = ['error' => ['Onboard screen not found!']];
            return Response::error($error,null,404);
        }


        // Update Status to Database
        try{
            $onboard_screen->update([
                'status'        => ($onboard_screen->status) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng! Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Onboard screen status updated successfully!.']];
        return Response::success($success,null,200);


    }


    /**
     * Function for update specific onboard screen information
     */
    public function onboardScreenUpdate(Request $request) {
        $target = $request->target ?? "";
        $onboard_screen = AppOnboardScreens::find($target);
        if(!$onboard_screen) {
            return back()->withErrors($request->all())->withInput()->with(['warning' => ['Onboard screen not found!']]);
        }
        $request->merge(['old_image' => $onboard_screen->image]);

        $validator = Validator::make($request->all(),[
            'target'              => 'required|numeric',
            'screen_title'        => 'nullable|string|max:120',
            'screen_sub_title'    => 'nullable|string|max:255',
            'screen_image'        => 'nullable|image|mimes:jpg,jpeg,png,svg,webp',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','onboard-screen-edit');
        }

        $validated = $validator->validate();
        $validated = Arr::except($validated,['target','screen_image']);

        if($request->hasFile('screen_image')) {
            try{
                $image = get_files_from_fileholder($request,'screen_image');
                $upload_image = upload_files_from_path_static($image,'app-images',$onboard_screen->image,true,true);
                $validated['screen_image']  = $upload_image;
            }catch(Exception $e) {
                return back()->withErrors($validator)->withInput()->with(['error' => ['Something went worng! Please try again.']]);
            }
        }

        $validated = replace_array_key($validated,"screen_");

        try{
            $onboard_screen->update($validated);
        }catch(Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Onboard screen information updated successfully!']]);
    }

    /**
     * Function for delete specific item form record
     * @param  \Illuminate\Http\Request  $request
     */
    public function onboardScreenDelete(Request $request) {
        $validator = Validator::make($request->all(),[
            'target'        => 'required|integer|exists:app_onboard_screens,id',
        ]);
        $validated = $validator->validate();

        try{
            AppOnboardScreens::find($validated['target'])->delete();
        }catch(Exception $e){
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Screen deleted successfully!']]);
    }
}
