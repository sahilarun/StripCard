<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers as ApiHelpers;
use App\Models\User;
use App\Models\UserAuthorization;
use App\Notifications\User\Auth\SendAuthorizationCode;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Traits\User\LoggedInUsers;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Traits\User\RegisteredUsers;

class LoginController extends Controller
{
    use  LoggedInUsers ,RegisteredUsers;
    protected $basic_settings;

    public function __construct()
    {
        $this->basic_settings = BasicSettingsProvider::get();
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:50',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return ApiHelpers::validation($error);
        }
        $user = User::where('username', trim(strtolower($request->email)))->orWhere('email',$request->email)->first();
        if(!$user){
            $error = ['error'=>['User does not exist']];
            return ApiHelpers::validation($error);
        }
        if (Hash::check($request->password, $user->password)) {
            if($user->status == 0){
                $error = ['error'=>['Account Has been Suspended']];
                return ApiHelpers::validation($error);
            }
            $this->refreshUserWallets($user);
            $this->createLoginLog($user);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $data = ['token' => $token, 'user' => $user, ];
            $message =  ['success'=>['Login Successful']];
            return ApiHelpers::success($data,$message);

        } else {
            $error = ['error'=>['Incorrect Password']];
            return ApiHelpers::error($error);
        }

    }

    public function register(Request $request){
        $basic_settings = $this->basic_settings;
        $passowrd_rule = "required|string|min:6";
        if($basic_settings->secure_password) {
            $passowrd_rule = ["required",Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()];
        }
        if( $basic_settings->agree_policy){
            $agree ='required';
        }else{
            $agree ='';
        }
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|max:160|unique:users',
            'password' => $passowrd_rule,
            'agree'         => $agree,
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return ApiHelpers::validation($error);
        }
        $data = $request->all();
        //User Create
        $user = new User();
        $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email = strtolower(trim($data['email']));
        $user->password = Hash::make($data['password']);
        $user->username = make_username($data['firstname'],$data['lastname']);
        $user->image = 'default.png';
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => '',
            'city' => ''
        ];
        $user->status = 1;
        $user->email_verified = ($basic_settings->email_verification == true) ? false : true;
        $user->sms_verified =  ($basic_settings->sms_verification == true) ? false : true;
        $user->kyc_verified =  ($basic_settings->kyc_verification == true) ? false : true;
        $user->save();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $this->createUserWallets($user);
        if ($basic_settings->email_verification == true) {
            $data = [
                'user_id'       => $user->id,
                'code'          => generate_random_code(),
                'token'         => generate_unique_string("user_authorizations","token",200),
                'created_at'    => now(),
            ];
            DB::beginTransaction();
            try{
                UserAuthorization::where("user_id",$user->id)->delete();
                DB::table("user_authorizations")->insert($data);
                $user->notify(new SendAuthorizationCode((object) $data));
                DB::commit();
            }catch(Exception $e) {
                DB::rollBack();
                $error = ['error'=>['Something went worng! Please try again']];
                return ApiHelpers::error($error);
            }
        }

        $data = ['token' => $token, 'user' => $user, ];
        $message =  ['success'=>['Registration Successful']];
        return ApiHelpers::success($data,$message);

    }

    public function logout(){
        Auth::user()->token()->revoke();
        $message = ['success'=>['Logout Successful']];
        return ApiHelpers::onlysuccess($message);

    }

}
