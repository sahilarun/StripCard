<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Auth::user();
        $countries = get_all_countries();

        $page_title = "Admin Profile";
        return view('admin.sections.profile.index',compact(
            'page_title','profile','countries',
        ));
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
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'email'     => ['required','email',Rule::unique('admins')->ignore(auth()->user()->id)],
            'phone'     => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpg,png,jpeg,webp,svg|max:10000',
            'country'   => 'nullable|string',
            'state'     => 'nullable|string',
            'city'      => 'nullable|string',
            'zip_postal'=> 'nullable|numeric',
            'address'   => 'nullable|string',
        ]);

        $validated = $validator->validate();

        if(!auth_is_super_admin()) {
            $validated = Arr::except($validated,['email']);
        }

        $admin = Auth::user();
        if($request->hasFile('image')) {
            $profile_image = get_files_from_fileholder($request,'image');
            $uploaded_image_name = upload_files_from_path_dynamic($profile_image,'admin-profile',$admin->image);
            $validated['image']     = $uploaded_image_name;
        }

        try{
           $admin->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => [$e]]);
        }

        return back()->with(['success' => ['Profile Information Updated Successfully!']]);
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


    /**
     * Password Change View.
     * @return view $change-password
     */
    public function changePassword() {
        $page_title = "Password Change";
        return view('admin.sections.profile.change-password',compact(
            'page_title',
        ));
    }

    /**
     * Update Admin Password
     * @param Request
     */
    public function updatePassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'current_password'      => 'required|string',
            'password'              => 'required|alpha_num|min:6|confirmed',
        ]);
        $validated = $validator->validate();
        if(!Hash::check($validated['current_password'],Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password'    => "Current password didn't match",
            ]);
        }

        try{
            Auth::user()->update([
                'password' => Hash::make($validated['password']),
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        return back()->with(['success' => ["Password updated successfully!"]]);
    }
}
