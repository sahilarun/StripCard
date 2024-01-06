<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\User;
use App\Mail\UserRegister;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;
use App\Mail\UserConfirmMail;
use Illuminate\Support\Carbon;
use App\Models\UserPasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\UserForgotPasswordCode;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Providers\Admin\BasicSettingsProvider;

class UserController extends Controller
{
    public $basic_settings;
    public function __construct()
    {
        $this->basic_settings = BasicSettingsProvider::get();
    }
    protected function createLoginLogs($admin)
    {

        $client_ip = request()->ip() ?? false;
        $location = geoip()->getLocation($client_ip);

        $agent = new Agent();

        $mac = "";

        $data = [
            'user_id'      => $admin->id,
            'ip'            => $client_ip,
            'mac'           => $mac,
            'city'          => $location['city'] ?? "",
            'country'       => $location['country'] ?? "",
            'longitude'     => $location['lon'] ?? "",
            'latitude'      => $location['lat'] ?? "",
            'timezone'      => $location['timezone'] ?? "",
            'browser'       => $agent->browser() ?? "",
            'os'            => $agent->platform() ?? "",
            'created_at'    => date('d-m-Y') ?? ""
        ];

        try {
            UserLoginLog::create($data);
        } catch (Exception $e) {
            info($e);
            return false;
        }
    }

    public function showLoginForm(Request $request)
    {

        if ($request->isMethod("POST")) {
            $data = $request->all();
            $activeCurrency = DB::table('currencies')->select('code', 'id', 'country', 'type')->where('status', '=', 1)->get();

            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);
            $userCheck = User::where(function ($query) use ($data) {
                $query->where('email', $data['username']);
            })->orWhere('username', $data['username'])->active()->first();
            if (isset($userCheck) && $userCheck->status == 0) {
                return redirect()->back()->with(['error' =>  ['Your account is not activated check mail inbox/spam.']]);
            }
            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            if (auth()->attempt(array($fieldType => $data['username'], 'password' => $data['password']))) {
                $user = Auth::user();
                // Create Login Logs
                $this->createLoginLogs($user);
                // Create wallet for user
                foreach ($activeCurrency as $currency) {
                    $walletCheck = UserWallet::where('user_id', $user->id)->where('currency_id', $currency->id)->count();
                    if ($walletCheck == 0) {
                        $wallet = new UserWallet();
                        $wallet->user_id = auth()->user()->id;
                        $wallet->currency_id =  $currency->id;
                        $wallet->balance = 0;
                        $wallet->save();
                    }
                }
                return redirect()->route('user.dashboard');
            } else {
                return redirect()->route('user.login')
                    ->with(['error' =>  ['Email-Address And Password Are Wrong.']]);
            }
        }
        return view('frontend.pages.auth.user_login');
    }

    public function checkCurrentUsername(Request $request)
    {
        $data = $request->all();
        $checkUserName = User::where('username', $data['username_input'])->count();
        if ($checkUserName > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $mailCount = User::where('email', $data['email'])->count();
        if ($mailCount > 0) {
            return "false";
        } else {
            return "true";
        }
    }


    public function userRegistration(Request $request)
    {
        $page_title = "Register Information";
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $rules = [
                'first_name' => 'required',
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|email|unique:users',
                'username' => 'required|string|regex:/\w*$/|max:255|unique:users,username',
                'password' => 'required|string|min:6',
                'accept' => 'required',
            ];
            //Validation message
            $customMessage = [
                'first_name.required' => 'First name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
                'accept.required' => 'Please Accept Terms Of Use , Privacy Policy & Warning'
            ];
            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            try {
                $user = new User();
                $user->username = Str::lower($data['username']);
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                if (isset($data['accept'])) {
                    $user->accept = $data['accept'];
                }
                if ($this->basic_settings->email_verification == 0) {
                    $user->status = 1;
                }
                $user->save();
                if (isset($this->basic_settings) && $this->basic_settings->email_verification == 1) {
                    Mail::to($data['email'])->send(new UserRegister($data['first_name'], base64_encode($data['email'])));
                    return redirect()->route('user.login')->with(['success' => ['Please check your email to activate your account.']]);
                } else {
                    return redirect()->route('user.login')->with(['success' => ['Registration successfull.']]);
                }
            } catch (Exception $e) {
                info($e);
                return redirect()->back()->with(['error' => ['Unable to save this action.']]);
            }
        }
        return view('frontend.pages.auth.register', compact('page_title'));
    }

    public function confirmAccount($email)
    {
        Session::forget('error');
        Session::forget('success');
        //Decode user email
        $email = base64_decode($email);
        //Check user email exist
        $vendorCount = User::where('email', $email)->count();
        if ($vendorCount > 0) {
            //User email alrady activated or not
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                Session::put('error');
                return redirect()->route('user.login')->with(['error' => 'Your email account is already activated! Please login']);
            } else {
                User::where('email', $email)->update(['status' => 1, 'email_verified' => 1, 'email_verified_at' => Carbon::now()]);
                try {
                    Mail::to($email)->send(new UserConfirmMail($userDetails->first_name, $userDetails->email));
                } catch (\Exception $ex) {
                    info($ex);
                }
                return redirect()->route('user.login')->with(['success' => ['Your email account is activated! You can login now and update your necessary information to upload product']]);
            }
        } else {
            abort(404);
        }
    }

    public function forgotPasswordCodeGenerate(Request $request)
    {
        if ($request->isMethod("POST")) {
            $data = $request->all();
            $userCheck = DB::table('users')->select('email', 'id', 'username')->where('email', '=', $data['email'])->first();
            if (isset($userCheck)) {
                $pass_r = new UserPasswordReset();
                $pass_r->email = $data['email'];
                $pass_r->user_id = $userCheck->id;
                $pass_r->password_reset_code = rand(1212, 9090);
                $pass_r->save();
                $lastId = DB::getPdo()->lastInsertId();
                $pwdCode = DB::table('user_password_resets')->where('email', '=', $data['email'])->where('id', $lastId)->pluck('password_reset_code')->first();
                Mail::to($data['email'])->send(new UserForgotPasswordCode($userCheck->username, $pwdCode));
                return redirect('user/enter/pwd/reset/code')->with(['success' => ['Please check email inbox/spam']]);
            } else {
                return redirect()->route('user.login')->with(['error' => ['Email not found']]);
            }
        }
    }
    public function enterPwdResetCode(Request $request)
    {
        if ($request->isMethod("POST")) {
            $data = $request->all();
            $userCheck = UserPasswordReset::with('user')->where('password_reset_code', '=', $data['password_reset_code'])->first();
            $userData = json_decode(json_encode($userCheck), true);
            if (isset($userData)) {
                return view('frontend.pages.auth.set_new_password', compact('userData'));
            } else {
                return redirect()->back()->with(['error' => ['Code not found']]);
            }
        }
        return view('frontend.pages.auth.pwd_reset_code');
    }
    public function setNewPassword(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $rules = [
                'new_password' => 'required|string|min:6',
            ];
            //Validation message
            $customMessage = [
                'new_password.required' => 'Password is required',
            ];
            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            $user->first_name = $user->first_name;
            $user->username  = $data['username'];
            $user->email   = $data['email'];
            $user->password = bcrypt($data['new_password']);
            $user->update();
            UserPasswordReset::where('user_id', $user->id)->delete();
            return redirect('/user/login')->with(['success' =>  ['Password Changed successfully login please!']]);
        } else {
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
    }
}
