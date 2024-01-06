<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Response;
use App\Models\Admin\BasicSettings;
use App\Models\Admin\SetupKyc;
use App\Models\Admin\SetupSeo;
use App\Providers\Admin\BasicSettingsProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class WebSettingsController extends Controller
{

    /**
     * Display The Basic Settings Page
     *
     * @return view
     */
    public function basicSettings()
    {
        $page_title = "Basic Settings";
        $basic_settings   = BasicSettings::first();
        return view('admin.sections.web-settings.basic-settings', compact(
            'page_title',
            'basic_settings',
        ));
    }


    public function basicSettingsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'base_color'        => 'required|string',
            // 'secondary_color'   => 'nullable|string',
            'web_version'       => 'required|string',
            'site_name'         => 'required|string',
            'site_title'        => 'required|string',
            'otp_exp_seconds'   => 'required|string',
            'timezone'          => 'required|string',
        ]);

        $validated = $validator->validate();

        $basic_settings = BasicSettings::first();
        if (!$basic_settings) return back()->with(['error' => ['Basic settings not found!']]);

        try {
            $basic_settings->update($validated);
            modifyEnv([
                "APP_NAME" => $validated['site_name'],
                "APP_TIMEZONE"  => $validated['timezone'],
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Basic settings updated successfully!']]);
    }

    public function basicSettingsActivationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status'                    => 'required|boolean',
            'input_name'                => 'required|string',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error, null, 400);
        }
        $validated = $validator->validate();

        $basic_settings = BasicSettingsProvider::get();
        // Check Email configure
        if ($validated['input_name'] == "email_verification") {
            if (!$basic_settings->mail_config) {
                $warning = ['warning' => ['You have to configure your system mail first.']];
                return Response::warning($warning, null, 400);
            }
        }

        if($validated['input_name'] == "kyc_verification") {
            $data = SetupKyc::first()->fields ?? null;
            if($data == null) {
                $warning = ['warning' => ['Please setup KYC field first. Go to [Setup KYC] page from sidebar']];
                return Response::warning($warning, null, 400);
            }
        }

        $validated['status'] = ($validated['status'] == true) ? false : true;

        if (!$basic_settings) {
            $error = ['error' => ['Basic settings not found!']];
            return Response::error($error, null, 404);
        }


        try {
            $basic_settings->update([
                $validated['input_name'] => $validated['status'],
            ]);
        } catch (Exception $e) {
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error, null, 500);
        }

        $success = ['success' => ['Basic settings status updated successfully!']];
        return Response::success($success, null, 200);
    }

    /**
     * Display The Image Assets Page
     *
     * @return view
     */
    public function imageAssets()
    {
        $page_title = "Image Assets";
        $basic_settings = BasicSettingsProvider::get();
        return view('admin.sections.web-settings.image-assets', compact(
            'page_title',
            'basic_settings',
        ));
    }


    public function imageAssetsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_logo'         => 'nullable|image|mimes:png,jpeg,jpg,webp,svg',
            'site_logo_dark'    => 'nullable|image|mimes:png,jpeg,jpg,webp,svg',
            'site_fav'          => 'nullable|image|mimes:png,jpeg,jpg,webp,svg',
            'site_fav_dark'     => 'nullable|image|mimes:png,jpeg,jpg,webp,svg',
        ]);
        $validated = $validator->validate();
        $basic_settings = BasicSettingsProvider::get();
        if (!$basic_settings) {
            return back()->with(['error' => ['Basic setting not found! Please run database seeder']]);
        }

        $images = [];
        foreach ($validated as $input_name => $item) {
            if ($request->hasFile($input_name)) {
                $image = get_files_from_fileholder($request, $input_name);
                $upload_image = upload_files_from_path_dynamic($image, 'image-assets', $basic_settings->$input_name);
                $images[$input_name] = $upload_image;
            }
        }

        if (count($images) == 0) {
            return back()->with(['warning' => ['No changes to update.']]);
        }

        // update images to database
        try {
            $basic_settings->update($images);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Image assets updated successfully!.']]);
    }

    /**
     * Display The SEO Setup Page
     *
     * @return view
     */
    public function setupSeo()
    {
        $page_title = "Setup SEO";
        $setup_seo = SetupSeo::first();
        return view('admin.sections.web-settings.setup-seo', compact(
            'page_title',
            'setup_seo',
        ));
    }


    public function setupSeoUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'nullable|image|mimes:png,jpg,webp,svg,jpeg',
            'title'         => 'required|string|max:120',
            'desc'          => 'nullable|string|max:255',
            'tags'          => 'nullable|array',
            'tags.*'        => 'nullable|string|max:30',
        ]);
        $validated = $validator->validate();
        $validated = Arr::except($validated, ['image']);

        $setup_seo = SetupSeo::first();

        if ($request->hasFile('image')) {
            $image = get_files_from_fileholder($request, 'image');
            $upload_image = upload_files_from_path_dynamic($image, 'seo', $setup_seo->image);
            $validated['image'] = $upload_image;
        }

        try {
            $setup_seo->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['SEO information updated successfully!']]);
    }

}
