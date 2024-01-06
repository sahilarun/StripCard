<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\GlobalConst;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPasswordReset;
use App\Notifications\User\Auth\PasswordResetEmail;
use App\Providers\Admin\BasicSettingsProvider;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForgotForm()
    {
        $page_title = "Forgot Password";
        return view('user.auth.forgot-password.forgot',compact('page_title'));
    }

    /**
     * Send Verification code to user email/phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'user'   => "required|email|max:100",
        ]);
        $column = "username";
        if(check_email($request->user)) $column = "email";
        $user = User::where($column,$request->user)->first();
        if(!$user) {
            throw ValidationException::withMessages([
                'user'       => "User doesn't exists.",
            ]);
        }else if($user->social_type != null && $user->social_type == 'facebook'){
            throw ValidationException::withMessages([
                'user'       => "You are login by facebook, please try with facebook",
            ]);
        }else if($user->social_type != null && $user->social_type == 'google'){

            throw ValidationException::withMessages([
                'user'       => "You are login by google,please try with google",
            ]);
        }

        $token = generate_unique_string("user_password_resets","token",80);
        $code = generate_random_code();

        try{
            UserPasswordReset::where("user_id",$user->id)->delete();
            $password_reset = UserPasswordReset::create([
                'user_id'       => $user->id,
                'token'         => $token,
                'code'          => $code,
            ]);
            $user->notify(new PasswordResetEmail($user,$password_reset));
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }
        return redirect()->route('user.password.forgot.code.verify.form',$token)->with(['success' => ['Varification code sended to your email address.']]);
    }


    public function showVerifyForm($token) {
        $page_title = "Verify User";
        $password_reset = UserPasswordReset::where("token",$token)->first();

        if(!$password_reset) return redirect()->route('user.password.forgot')->with(['error' => ['Password Reset Token Expired']]);
        $resend_time = 0;
        if(Carbon::now() <= $password_reset->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) {
            $resend_time = Carbon::now()->diffInSeconds($password_reset->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE));
        }
        $user_email = $password_reset->user->email ?? "";
        return view('user.auth.forgot-password.verify',compact('page_title','token','user_email','resend_time'));
    }

    /**
     * OTP Verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyCode(Request $request,$token)
    {
        $request->merge(['token' => $token]);
        $validated = Validator::make($request->all(),[
            'token'         => "required|string|exists:user_password_resets,token",
            // 'code'          => "required|numeric|exists:user_password_resets,code",
            'code'      => "required|array",
            'code.*'    => "required|numeric",
        ])->validate();
        $code = $request->code;
        $code = implode("",$code);

        $basic_settings = BasicSettingsProvider::get();
        $otp_exp_seconds = $basic_settings->otp_exp_seconds ?? 0;

        $password_reset = UserPasswordReset::where("token",$token)->first();
        if(Carbon::now() >= $password_reset->created_at->addSeconds($otp_exp_seconds)) {
            foreach(UserPasswordReset::get() as $item) {
                if(Carbon::now() >= $item->created_at->addSeconds($otp_exp_seconds)) {
                    $item->delete();
                }
            }
            return redirect()->route('user.password.forgot')->with(['error' => ['Session expired. Please try again.']]);
        }

        if($password_reset->code != $code) {
            throw ValidationException::withMessages([
                'code'      => "Verification Otp is Invalid",
            ]);
        }

        return redirect()->route('user.password.forgot.reset.form',$token);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resendCode($token)
    {
        $password_reset = UserPasswordReset::where('token',$token)->first();
        if(!$password_reset) return back()->with(['error' => ['Request token is invalid']]);
        if(Carbon::now() <= $password_reset->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) {
            throw ValidationException::withMessages([
                'code'      => 'You can resend verification code after '.Carbon::now()->diffInSeconds($password_reset->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)). ' seconds',
            ]);
        }

        DB::beginTransaction();
        try{
            $update_data = [
                'code'          => generate_random_code(),
                'created_at'    => now(),
                'token'         => $token,
            ];
            DB::table('user_password_resets')->where('token',$token)->update($update_data);
            $password_reset->user->notify(new PasswordResetEmail($password_reset->user,(object) $update_data));
            DB::commit();
        }catch(Exception $e) {
            DB::rollback();
            return back()->with(['error' => ['Something went worng. please try again']]);
        }
        return redirect()->route('user.password.forgot.code.verify.form',$token)->with(['success' => ['Varification code resend success!']]);

    }


    public function showResetForm($token) {
        $page_title = "Reset Password";
        return view('user.auth.forgot-password.reset',compact('page_title','token'));
    }


    public function resetPassword(Request $request,$token) {
        $basic_settings = BasicSettingsProvider::get();
        $passowrd_rule = "required|string|min:6|confirmed";
        if($basic_settings->secure_password) {
            $passowrd_rule = ["required",Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),"confirmed"];
        }

        $request->merge(['token' => $token]);
        $validated = Validator::make($request->all(),[
            'token'         => "required|string|exists:user_password_resets,token",
            'password'      => $passowrd_rule,
        ])->validate();

        $password_reset = UserPasswordReset::where("token",$token)->first();
        if(!$password_reset) {
            throw ValidationException::withMessages([
                'password'      => "Invalid Request. Please try again.",
            ]);
        }

        try{
            $password_reset->user->update([
                'password'      => Hash::make($validated['password']),
            ]);
            $password_reset->delete();
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return redirect()->route('index')->with(['success' => ['Password reset success. Please login with new password.']]);
    }

}
