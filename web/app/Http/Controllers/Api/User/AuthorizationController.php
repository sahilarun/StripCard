<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Helpers\Response;
use App\Models\Admin\SetupKyc;
use Illuminate\Support\Carbon;
use App\Http\Helpers\Api\Helpers;
use App\Models\UserAuthorization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\Admin\BasicSettingsProvider;
use App\Notifications\User\Auth\SendAuthorizationCode;
use App\Traits\ControlDynamicInputFields;

class AuthorizationController extends Controller
{
    use ControlDynamicInputFields;
    public function sendMailCode()
    {
        $user = auth()->user();
        $resend = UserAuthorization::where("user_id",$user->id)->first();
        if( $resend){
            if(Carbon::now() <= $resend->created_at->addMinutes(GlobalConst::USER_VERIFY_RESEND_TIME_MINUTE)) {

                $error = ['error'=>['You can resend verification code after '.Carbon::now()->diffInSeconds($resend->created_at->addMinutes(GlobalConst::USER_VERIFY_RESEND_TIME_MINUTE)). ' seconds']];
                return Helpers::error($error);
            }
        }

        $data = [
            'user_id'       =>  $user->id,
            'code'          => generate_random_code(),
            'token'         => generate_unique_string("user_authorizations","token",200),
            'created_at'    => now(),
        ];
        DB::beginTransaction();
        try{
            if($resend) {
                UserAuthorization::where("user_id", $user->id)->delete();
            }
            DB::table("user_authorizations")->insert($data);
            $user->notify(new SendAuthorizationCode((object) $data));
            DB::commit();
            $message =  ['success'=>['Verification code send success']];
            return Helpers::onlysuccess($message);
        }catch(Exception $e) {
            DB::rollBack();
            $error = ['error'=>['Something went wrong! Please try again']];
            return Helpers::error($error);
        }
    }
    public function mailVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
        ]);
        if($validator->fails()){
            $error =  ['error'=>$validator->errors()->all()];
            return Helpers::validation($error);
        }
        $user = auth()->user();
        $code = $request->code;
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = UserAuthorization::where("user_id",$user->id)->where("code",$code)->first();

        if(!$auth_column){
             $error = ['error'=>['Verification code does not match']];
            return Helpers::error($error);
        }
        if($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            $error = ['error'=>['Session expired. Please try again']];
            return Helpers::error($error);
        }
        try{
            $auth_column->user->update([
                'email_verified'    => true,
            ]);
            $auth_column->delete();
        }catch(Exception $e) {
            $error = ['error'=>['Something went wrong! Please try again']];
            return Helpers::error($error);
        }
        $message =  ['success'=>['Account successfully verified']];
        return Helpers::onlysuccess($message);
    }


     // Get KYC Input Fields
     public function getKycInputFields() {
        $user = auth()->guard(get_auth_guard())->user();

        $user_kyc = SetupKyc::userKyc()->first();
        $kyc_data = $user_kyc->fields;
        $kyc_fields = array_reverse($kyc_data);

        $data = [
            'status_info' => '0: Unverified, 1: Verified, 2: Pending, 3: Rejected',
            'kyc_status' => $user->kyc_verified,
            'input_fields' => $kyc_fields
        ];


        $message = ['success' => ['You are already KYC Verified User']];
        if($user->kyc_verified == GlobalConst::VERIFIED) return Helpers::success($data,$message);
        $message = ['success' => ['Your KYC information is submitted. Please wait for admin confirmation']];
        if($user->kyc_verified == GlobalConst::PENDING) return Helpers::success($data,$message);
        $message = ['success' => ['User KYC section is under maintenance']];
        if(!$user_kyc) return Helpers::success($data,$message);
        $message = ['success' => ['User KYC input fields fetch successfully!']];


        return Helpers::success($data, $message);
    }


    public function KycSubmit(Request $request) {
        $user = auth()->guard(get_auth_guard())->user();
        if($user->kyc_verified == GlobalConst::VERIFIED) return Response::warning(['You are already KYC Verified User'],[],400);

        $user_kyc_fields = SetupKyc::userKyc()->first()->fields ?? [];
        $validation_rules = $this->generateValidationRules($user_kyc_fields);

        $validated = Validator::make($request->all(),$validation_rules)->validate();
        $get_values = $this->placeValueWithFields($user_kyc_fields,$validated);

        $create = [
            'user_id'       => auth()->guard(get_auth_guard())->user()->id,
            'data'          => json_encode($get_values),
            'created_at'    => now(),
        ];

        DB::beginTransaction();
        try{
            DB::table('user_kyc_data')->updateOrInsert(["user_id" => $user->id],$create);
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            $user->update([
                'kyc_verified'  => GlobalConst::DEFAULT,
            ]);
            $this->generatedFieldsFilesDelete($get_values);
            return Response::error(['Something went wrong! Please try again'],[],500);
        }

        return Response::success(['KYC information successfully submitted'],[],200);
    }



}
