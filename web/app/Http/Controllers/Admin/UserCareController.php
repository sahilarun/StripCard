<?php

namespace App\Http\Controllers\Admin;

use App\Constants\GlobalConst;
use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Events\User\NotificationEvent;
use Exception;
use App\Models\User;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserMailLog;
use App\Notifications\User\SendMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Response;
use App\Models\Transaction;
use App\Models\UserNotification;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class UserCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "All Users";
        $users = User::orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }

    /**
     * Display Active Users
     * @return view
     */
    public function active()
    {
        $page_title = "Active Users";
        $users = User::active()->orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }


    /**
     * Display Banned Users
     * @return view
     */
    public function banned()
    {
        $page_title = "Banned Users";
        $users = User::banned()->orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users',
        ));
    }

    /**
     * Display Email Unverified Users
     * @return view
     */
    public function emailUnverified()
    {
        $page_title = "Email Unverified Users";
        $users = User::active()->orderBy('id', 'desc')->emailUnverified()->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }

    /**
     * Display SMS Unverified Users
     * @return view
     */
    public function SmsUnverified()
    {
        $page_title = "SMS Unverified Users";
        return view('admin.sections.user-care.index', compact(
            'page_title',
        ));
    }

    /**
     * Display KYC Unverified Users
     * @return view
     */
    public function KycUnverified()
    {
        $page_title = "KYC Unverified Users";
        $users = User::kycUnverified()->orderBy('id', 'desc')->paginate(8);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }

    /**
     * Display Send Email to All Users View
     * @return view
     */
    public function emailAllUsers()
    {
        $page_title = "Email To Users";
        return view('admin.sections.user-care.email-to-users', compact(
            'page_title',
        ));
    }

    /**
     * Display Specific User Information
     * @return view
     */
    public function userDetails($username)
    {
        $page_title = "User Details";
        $user = User::where('username', $username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User not exists']]);

        $balance = UserWallet::where('user_id', $user->id)->first()->balance ?? 0;
        $add_money_amount = Transaction::toBase()->where('user_id', $user->id)->where('type', PaymentGatewayConst::TYPEADDMONEY)->where('status', 1)->sum('request_amount');
        $total_transaction = Transaction::toBase()->where('user_id', $user->id)->where('status', 1)->sum('request_amount');

        $data = [
            'balance'              => $balance,
            'total_transaction'    => $total_transaction,
            'add_money_amount'    => $add_money_amount,
        ];
        return view('admin.sections.user-care.details', compact(
            'page_title',
            'user',
            'data',
        ));
    }

    public function sendMailUsers(Request $request) {
        $request->validate([
            'user_type'     => "required|string|max:30",
            'subject'       => "required|string|max:250",
            'message'       => "required|string|max:2000",
        ]);

        $users = [];
        switch($request->user_type) {
            case "active";
                $users = User::active()->get();
                break;
            case "all";
                $users = User::get();
                break;
            case "email_verified";
                $users = User::emailVerified()->get();
                break;
            case "kyc_verified";
                $users = User::kycVerified()->get();
                break;
            case "banned";
                $users = User::banned()->get();
                break;
        }

        try{
            Notification::send($users,new SendMail((object) $request->all()));
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Email successfully sended']]);

    }

    public function sendMail(Request $request, $username)
    {
        $request->merge(['username' => $username]);
        $validator = Validator::make($request->all(),[
            'subject'       => 'required|string|max:200',
            'message'       => 'required|string|max:2000',
            'username'      => 'required|string|exists:users,username',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal","email-send");
        }
        $validated = $validator->validate();
        $user = User::where("username",$username)->first();
        $validated['user_id'] = $user->id;
        $validated = Arr::except($validated,['username']);
        $validated['method']   = "SMTP";
        try{
            UserMailLog::create($validated);
            $user->notify(new SendMail((object) $validated));
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }
        return back()->with(['success' => ['Mail successfully sended']]);
    }

    public function userDetailsUpdate(Request $request, $username)
    {
        $request->merge(['username' => $username]);
        $validator = Validator::make($request->all(),[
            'username'              => "nullable|exists:users,username",
            'firstname'             => "required|string|max:60",
            'lastname'              => "required|string|max:60",
            'mobile_code'           => "required|string|max:10",
            'mobile'                => "required|string|max:20",
            'address'               => "nullable|string|max:250",
            'country'               => "nullable|string|max:50",
            'state'                 => "nullable|string|max:50",
            'city'                  => "nullable|string|max:50",
            'zip_code'              => "nullable|numeric|max_digits:8",
            'email_verified'        => 'required|boolean',
            'two_factor_verified'   => 'nullable|boolean',
            'kyc_verified'          => 'nullable|boolean',
            'status'                => 'required|boolean',
        ]);
        $validated = $validator->validate();
        $validated['address']  = [
            'country'       => $validated['country'] ?? "",
            'state'         => $validated['state'] ?? "",
            'city'          => $validated['city'] ?? "",
            'zip'           => $validated['zip_code'] ?? "",
            'address'       => $validated['address'] ?? "",
        ];
        $validated['mobile_code']       = remove_speacial_char($validated['mobile_code']);
        $validated['mobile']            = remove_speacial_char($validated['mobile']);
        $validated['full_mobile']       = $validated['mobile_code'] . $validated['mobile'];

        $user = User::where('username', $username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User not exists']]);

        try {
            $user->update($validated);
        } catch (Exception $e) {

            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Profile Information Updated Successfully!']]);
    }

    public function loginLogs($username)
    {
        $page_title = "Login Logs";
        $user = User::where("username",$username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User doesn\'t exists']]);
        $logs = UserLoginLog::where('user_id',$user->id)->paginate(12);
        return view('admin.sections.user-care.login-logs', compact(
            'logs',
            'page_title',
        ));
    }

    public function mailLogs($username) {
        $page_title = "User Email Logs";
        $user = User::where("username",$username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User doesn\'t exists']]);
        $logs = UserMailLog::where("user_id",$user->id)->paginate(12);
        return view('admin.sections.user-care.mail-logs',compact(
            'page_title',
            'logs',
        ));
    }

    public function loginAsMember(Request $request,$username) {
        $request->merge(['username' => $username]);
        $request->validate([
            'target'            => 'required|string|exists:users,username',
            'username'          => 'required_without:target|string|exists:users',
        ]);

        try{
            $user = User::where("username",$request->username)->first();
            Auth::guard("web")->login($user);
        }catch(Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
        return redirect()->intended(route('user.dashboard'));
    }

    public function kycDetails($username) {
        $user = User::where("username",$username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User doesn\'t exists']]);

        $page_title = "KYC Profile";
        return view('admin.sections.user-care.kyc-details',compact("page_title","user"));
    }

    public function kycApprove(Request $request, $username) {
        $request->merge(['username' => $username]);
        $request->validate([
            'target'        => "required|exists:users,username",
            'username'      => "required_without:target|exists:users,username",
        ]);
        $user = User::where('username',$request->target)->orWhere('username',$request->username)->first();
        if($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['warning' => ['User already KYC verified']]);
        if($user->kyc == null) return back()->with(['error' => ['User KYC information not found']]);

        try{
            $user->update([
                'kyc_verified'  => GlobalConst::APPROVED,
            ]);
        }catch(Exception $e) {
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }
        return back()->with(['success' => ['User KYC successfully approved']]);
    }

    public function kycReject(Request $request, $username) {
        $request->validate([
            'target'        => "required|exists:users,username",
            'reason'        => "required|string|max:500"
        ]);
        $user = User::where("username",$request->target)->first();
        if(!$user) return back()->with(['error' => ['User doesn\'t exists']]);
        if($user->kyc == null) return back()->with(['error' => ['User KYC information not found']]);

        try{
            $user->update([
                'kyc_verified'  => GlobalConst::REJECTED,
            ]);
            $user->kyc->update([
                'reject_reason' => $request->reason,
            ]);
        }catch(Exception $e) {
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            $user->kyc->update([
                'reject_reason' => null,
            ]);

            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['User KYC information is rejected']]);
    }


    public function search(Request $request) {
        $validator = Validator::make($request->all(),[
            'text'  => 'required|string',
        ]);

        if($validator->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }

        $validated = $validator->validate();
        $users = User::search($validated['text'])->limit(10)->get();
        return view('admin.components.search.user-search',compact(
            'users',
        ));
    }
    public function walletBalanceUpdate(Request $request,$username) {
        $validator = Validator::make($request->all(),[
            'type'      => "required|string|in:add,subtract",
            'wallet'    => "required|numeric|exists:user_wallets,id",
            'amount'    => "required|numeric",
            'remark'    => "required|string|max:200",
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','wallet-balance-update-modal');
        }

        $validated = $validator->validate();
        $user_wallet = UserWallet::whereHas('user',function($q) use ($username){
            $q->where('username',$username);
        })->find($validated['wallet']);
        if(!$user_wallet) return back()->with(['error' => ['User wallet not found!']]);

        DB::beginTransaction();
        try{

            $user_wallet_balance = 0;

            switch($validated['type']){
                case "add":
                    $user_wallet_balance = $user_wallet->balance + $validated['amount'];
                    $user_wallet->balance += $validated['amount'];
                    break;

                case "subtract":
                    if($user_wallet->balance >= $validated['amount']) {
                        $user_wallet_balance = $user_wallet->balance - $validated['amount'];
                        $user_wallet->balance -= $validated['amount'];
                    }else {
                        return back()->with(['error' => ['User do not have sufficient balance']]);
                    }
                    break;
            }

            $inserted_id = DB::table("transactions")->insertGetId([
                'admin_id'          => auth()->user()->id,
                'user_id'           => $user_wallet->user->id,
                'user_wallet_id'    => $user_wallet->id,
                'type'              => PaymentGatewayConst::TYPEADDSUBTRACTBALANCE,
                'attribute'         => PaymentGatewayConst::RECEIVED,
                'trx_id'            => generate_unique_string("transactions","trx_id",16),
                'request_amount'    => $validated['amount'],
                'payable'           => $validated['amount'],
                'available_balance' => $user_wallet_balance,
                'remark'            => $validated['remark'],
                'created_at'        => now(),
                'status'            => GlobalConst::SUCCESS,
            ]);


            DB::table('transaction_charges')->insert([
                'transaction_id'    => $inserted_id,
                'percent_charge'    => 0,
                'fixed_charge'      => 0,
                'total_charge'      => 0,
                'created_at'        => now(),
            ]);


            $client_ip = request()->ip() ?? false;
            $location = geoip()->getLocation($client_ip);
            $agent = new Agent();
            
            $mac = "";

            DB::table("transaction_devices")->insert([
                'transaction_id'=> $inserted_id,
                'ip'            => $client_ip,
                'mac'           => $mac,
                'city'          => $location['city'] ?? "",
                'country'       => $location['country'] ?? "",
                'longitude'     => $location['lon'] ?? "",
                'latitude'      => $location['lat'] ?? "",
                'timezone'      => $location['timezone'] ?? "",
                'browser'       => $agent->browser() ?? "",
                'os'            => $agent->platform() ?? "",
            ]);

            $user_wallet->save();

            $notification_content = [
                'title'         => "Update Balance",
                'message'       => "Your Wallet (".$user_wallet->currency->code.") balance has been update",
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::BALANCE_UPDATE,
                'user_id'  => $user_wallet->user->id,
                'message'   => $notification_content,
            ]);
            event(new NotificationEvent($notification_content,$user_wallet->user));
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return back()->with(['error' => ['Transaction faild! '. $e->getMessage()]]);
        }

        return back()->with(['success' => ['Transaction success']]);
    }
}
