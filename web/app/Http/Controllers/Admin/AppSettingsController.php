<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AppSettings;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class AppSettingsController extends Controller
{

    /**
     * Display The App Splash Screen Settings Page
     *
     * @return view
     */
    public function splashScreen() {
        $page_title = "Splash Screen";
        $app_settings = AppSettings::first();
        return view('admin.sections.app-settings.splash-screen',compact(
            'page_title',
            'app_settings',
        ));
    }


    public function splashScreenUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'image'         => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
            'version'       => 'required|string|max:15',
        ]);
        $validated = $validator->validate();
        $validated = Arr::except($validated,['image']);

        $app_settings = AppSettings::first();

        if($request->hasFile('image')) {
            $image = get_files_from_fileholder($request,'image');
            $upload_image = upload_files_from_path_static($image,'splash-images',$app_settings->splash_screen_image,true,true);
            $validated['splash_screen_image']   = $upload_image;
        }

        try{
            $app_settings->updateOrCreate(['id' => 1],$validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Splash screen updated successfully!']]);

    }


    /**
     * Display The App URL Setting Page
     *
     * @return view
     */
    public function urls() {
        $page_title = "App URLs";
        $app_settings = AppSettings::first();
        return view('admin.sections.app-settings.urls',compact(
            'page_title',
            'app_settings',
        ));
    }


    public function urlsUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'url_title'     => 'required|string|max:255',
            'android_url'   => 'required|string|url|max:255',
            'iso_url'       => 'nullable|string|url|max:255|different:android_url',
        ]);
        $validated = $validator->validate();

        try{
            $app_settings = AppSettings::updateOrCreate(['id' => 1],$validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['URL settings updated successfully!']]);
    }
}
