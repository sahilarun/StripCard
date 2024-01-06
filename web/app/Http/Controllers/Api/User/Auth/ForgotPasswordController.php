<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers;
use App\Models\User;
use App\Models\UserPasswordReset;
use App\Notifications\User\Auth\PasswordResetEmail;
use App\Providers\Admin\BasicSettingsProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => "required|email|max:100",
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $column = "email";
        if(check_email($request->email)) $column = "email";
        $user = User::where($column,$request->email)->first();
        if(!$user) {
            $error = ['error'=>["User doesn't exists."]];
            return Helpers::error($error);
        }
        $token = generate_unique_string("user_password_resets","token",80);
        $code = generate_random_code();

        try{
            UserPasswordReset::where("user_id",$user->id)->delete();
            $password_reset = UserPasswordReset::create([
                'user_id'       => $user->id,
                'email'         => $request->email,
                'token'         => $token,
                'code'          => $code,
            ]);
            $user->notify(new PasswordResetEmail($user,$password_reset));
        }catch(Exception $e) {
            $error = ['error'=>['Something went worng! Please try again']];
            return Helpers::error($error);
        }

        $message =  ['success'=>['Varification code sent to your email address']];
        return Helpers::onlysuccess($message);
    }
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $code = $request->code;
        $basic_settings = BasicSettingsProvider::get();
        $otp_exp_seconds = $basic_settings->otp_exp_seconds ?? 0;
        $password_reset = UserPasswordReset::where("code", $code)->first();
        if(!$password_reset) {
            $error = ['error'=>['Verification Otp is Invalid']];
            return Helpers::error($error);
        }
        if(Carbon::now() >= $password_reset->created_at->addSeconds($otp_exp_seconds)) {
            foreach(UserPasswordReset::get() as $item) {
                if(Carbon::now() >= $item->created_at->addSeconds($otp_exp_seconds)) {
                    $item->delete();
                }
            }
            $error = ['error'=>['Session expired. Please try again']];
            return Helpers::error($error);
        }

        $message =  ['success'=>['Your verification is successful, Now you can recover your password']];
        return Helpers::onlysuccess($message);
    }
    public function resetPassword(Request $request) {
        $basic_settings = BasicSettingsProvider::get();
        $passowrd_rule = "required|string|min:6|confirmed";
        if($basic_settings->secure_password) {
            $passowrd_rule = ["required",Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),"confirmed"];
        }

        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
            'password'      => $passowrd_rule,
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $code = $request->code;
        $password_reset = UserPasswordReset::where("code",$code)->first();
        if(!$password_reset) {
            $error = ['error'=>['invalid request']];
            return Helpers::error($error);
        }
        try{
            $password_reset->user->update([
                'password'      => Hash::make($request->password),
            ]);
            $password_reset->delete();
        }catch(Exception $e) {
            $error = ['error'=>['Something went worng! Please try again']];
            return Helpers::error($error);
        }
        $message =  ['success'=>['Password reset success. Please login with new password.']];
        return Helpers::onlysuccess($message);
    }

}
