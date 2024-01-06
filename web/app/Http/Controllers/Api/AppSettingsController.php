<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers;
use App\Models\Admin\AppOnboardScreens;
use App\Models\Admin\AppSettings;
use App\Models\Admin\BasicSettings;
use App\Models\Admin\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AppSettingsController extends Controller
{
    public function appSettings(){
        $splash_screen = AppSettings::get()->map(function($splash_screen){
            return[
                'id' => $splash_screen->id,
                'splash_screen_image' => $splash_screen->splash_screen_image,
                'version' => $splash_screen->version,
                'created_at' => $splash_screen->created_at,
                'updated_at' => $splash_screen->updated_at,
            ];
        })->first();
        $app_url = AppSettings::get()->map(function($url){
            return[
                'id' => $url->id,
                'android_url' => $url->android_url,
                'iso_url' => $url->iso_url,
                'created_at' => $url->created_at,
                'updated_at' => $url->updated_at,
            ];
        })->first();
        $onboard_screen = AppOnboardScreens::orderByDesc('id')->where('status',1)->get()->map(function($data){
            return[
                'id' => $data->id,
                'title' => $data->title,
                'sub_title' => $data->sub_title,
                'image' => $data->image,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];

        });
        $basic_settings = BasicSettings::first();
        $all_logo = [
            "site_logo_dark" =>  @$basic_settings->site_logo_dark,
            "site_logo" =>  @$basic_settings->site_logo,
            "site_fav_dark" =>  @$basic_settings->site_fav_dark,
            "site_fav" =>  @$basic_settings->site_fav,
        ];
        $data =[
            "default_logo"          => "public/backend/images/default/default.webp",
            "image_path"            =>  "public/backend/images/app",
            'onboard_screen'        => $onboard_screen,
            'splash_screen'         => (object)$splash_screen,
            'app_url'               =>   (object)$app_url,
            'all_logo'              =>   (object)$all_logo,
            "logo_image_path"       => "public/backend/images/web-settings/image-assets"

        ];
        $message =  ['success'=>['Data fetched successfully']];
        return Helpers::success($data,$message);

    }
    public function languages()
    {
        $message = ['success' => ['Languages']];
        $file_path = get_files_path('language-file');
        $file_name = get_first_file_from_dir($file_path);
        if ($file_name == false) {
            return back()->with(['error' => ['File does not exists.']]);
        }
        $languages = Language::get();
        $response = [];
        foreach ($languages as $language) {
            $json = lang_path($language['code'] . ".json");
            if (!File::exists($json)) continue;
            $json = json_decode(file_get_contents($json), true);
            $json = $json ?? [];
            $lan_key_values = [];
            if ($json != null) {
                $loop = 0;
                foreach ($json as $lan_key => $item) {
                    $loop++;
                    $lan_key = preg_replace('/[^A-Za-z]/i', ' ', strtolower($lan_key));
                    if (strlen($lan_key) > 20) {
                        // $lan_key = substr($lan_key,0,20);
                        $word_array = explode(" ", $lan_key);
                        $count_char = 0;
                        foreach ($word_array as $word_key => $word) {
                            $count_char += strlen($word);
                            if ($count_char > 20) {
                                $get_limit_val = array_splice($word_array, 0, $word_key);
                                $lan_key = implode(" ", $get_limit_val);
                                $count_char = 0;
                                break;
                            }
                        }
                    }
                    // Make Key Readable
                    $var_array = explode(" ", $lan_key);
                    foreach ($var_array as $key => $var) {
                        if ($key > 0) {
                            $var_array[$key] = ucwords($var);
                        }
                    }
                    $lan_key = implode("", $var_array);
                    ($lan_key != "") ? $lan_key_values[$lan_key] = $item : "";
                }
            }
            $response[] = [
                'id'                    => $language->id,
                'name'                  => $language->name,
                'code'                  => $language->code,
                'status'                => $language->status,
                'translate_key_values'  => $lan_key_values,
            ];
        }
        return response()->json(['message' => $message, 'data' => $response], 200);
    }
}
