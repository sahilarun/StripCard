<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;


class SettingsController extends Controller
{
    public function dashboard()
    {
        return view('frontend.pages.user.dashboard');
    }
    public function profile($username)
    {
        $user_row = User::with('kyc_profile')->where('username', $username)->first();
        $user = json_decode(json_encode($user_row), true);
        $countries = get_all_countries();
        return view('frontend.pages.user.profile', compact('user', 'countries'));
    }
    public function profileUpdate(Request $request, $username)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'mobile'     => 'nullable|string',
            'address'   => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpg,png,jpeg,webp,svg|max:10000',
            'country'   => 'nullable|string',
            'state'     => 'nullable|string',
            'city'      => 'nullable|string',
            'zip_code' => 'nullable|numeric',
        ]);
        $validated = $validator->validate();
        $user = User::where('username', $username)->firstOrFail();

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName  = Str::uuid() . '.' . $image->getClientOriginalExtension();
            create_dir('public/frontend/user');
            delete_file(get_files_path('user-profile').'/'. $user->image);
            Image::make($image)->resize(200, 200)->save(get_files_path('user-profile').'/'. $imageName);
        } else {

            $imageName = $user->image;
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->image = $imageName;
        $user->address = $request->address;
        $user->update();

        $userProife = UserProfile::where('user_id', $user->id)->firstOrFail();
        
        $userProife->country = $request->country;
        $userProife->state = $request->state ?? null;
        $userProife->city = $request->city ?? null;
        $userProife->zip_code = $request->zip_code ?? null;
        $userProife->update();

        return back()->with(['success' => ['Profile Information Updated Successfully!']]);
    }

    public function passwordUpdate(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            //Check if current password is correct or not
            if (Hash::check($data['current_password'], Auth::user()->password)) {
                //Check new and confirm password is matching
                if ($data['new_password'] == $data['again_new_password']) {
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($request->new_password);
                    $user->save();
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/user/login')->with(['success' =>  ['Password Changed successfully login again!']]);
                } else {
                    return redirect()->back()->with(['error' => ['New password & confirm password is not same!']]);
                }
            } else {
                return redirect()->back()->with(['error' => ['Password not updated!']]);
            }
            return redirect()->back();
        }
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_password'], Auth::user()->password)) {
            echo "true";
        } else {
            echo "false";
        }
    }

}
