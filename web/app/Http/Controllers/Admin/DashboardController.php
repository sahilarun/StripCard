<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\Admin\BasicSettingsProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\PushNotifications\PushNotifications;
use App\Models\Admin\AdminNotification;
use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Helpers\Response;
use App\Models\Blog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VirtualCardApi;

class DashboardController extends Controller
{
    protected $api;
    public function __construct()
    {
        $cardApi = VirtualCardApi::first();
        $this->api =  $cardApi;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title = "Dashboard";
        $transactions = Transaction::with(
            'user:id,firstname,lastname,email,username,full_mobile',
              'currency:id,name'
          )->where('type', 'ADD-MONEY')->latest()->take(5)->get();

        $last_month_start =  date('Y-m-01', strtotime('-1 month', strtotime(date('Y-m-d'))));
        $last_month_end =  date('Y-m-31', strtotime('-1 month', strtotime(date('Y-m-d'))));
        $this_month_start = date('Y-m-01');
        $this_month_end = date('Y-m-d');
        $this_weak = date('Y-m-d', strtotime('-1 week', strtotime(date('Y-m-d'))));
        $this_month = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))));
        $this_year = date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))));

        // Dashboard box data
        // Add Money
        $add_money_balance = Transaction::toBase()->where('type', PaymentGatewayConst::TYPEADDMONEY)->where('status', 1)->sum('request_amount');
        $add_money_total_balance = Transaction::toBase()->where('type', PaymentGatewayConst::TYPEADDMONEY)->sum('request_amount');
        $today_add_money =  Transaction::toBase()
                            ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                            ->where('status', 1)
                            ->whereDate('created_at','>=',$this_month_start)
                            ->whereDate('created_at','<=',$this_month_end)
                            ->sum('request_amount');
        $last_month_add_money =  Transaction::toBase()->where('status', 1)
                                            ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                            ->whereDate('created_at','>=',$last_month_start)
                                            ->whereDate('created_at','<=',$last_month_end)
                                            ->sum('request_amount');
        if($last_month_add_money == 0){
            $add_money_percent = 100;
        }else{
            $add_money_percent = (($today_add_money * 100) / $last_month_add_money);
        }

        // Pending Add Money
        $pending_add_money_balance = Transaction::toBase()->where('type', PaymentGatewayConst::TYPEADDMONEY)->where('status', 2)->sum('request_amount');
        $today_pending_add_money =  Transaction::toBase()
                                    ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                    ->where('status', 2)
                                    ->whereDate('created_at','>=',$this_month_start)
                                    ->whereDate('created_at','<=',$this_month_end)
                                    ->sum('request_amount');
        $last_month_pending_add_money =  Transaction::toBase()->where('status', 2)
                                            ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                            ->whereDate('created_at','>=',$last_month_start)
                                            ->whereDate('created_at','<=',$last_month_end)
                                            ->sum('request_amount');
        if($last_month_pending_add_money == 0){
            $pending_add_money_percent = 100;
        }else{
            $pending_add_money_percent = (($pending_add_money_balance * 100) / $last_month_pending_add_money);
        }
        //User
        $total_user = User::toBase()->count();
        $unverified_user = User::toBase()->where('email_verified', 0)->count();
        $active_user = User::toBase()->where('status', 1)->count();
        $banned_user = User::toBase()->where('status', 0)->count();

        if($total_user == 0){
            $user_percent = 100;
        }else{
            $user_percent = (($active_user * 100) / $total_user);
        }

        // Monthly Add Money
        $start = strtotime(date('Y-m-01'));
        $end = strtotime(date('Y-m-31'));

        // Add Money
        $pending_data  = [];
        $success_data  = [];
        $canceled_data = [];
        $hold_data     = [];
        //virtual card
        $card_pending_data  =[];
        $card_success_data  = [];
        $card_canceled_data = [];
        $card_hold_data     = [];
         //Announcement
         $event_data    = [];
         $all_data    = [];

        $month_day  = [];
        while ($start <= $end) {
            $start_date = date('Y-m-d', $start);

            // Monthley add money
            $pending = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                                        ->whereDate('created_at',$start_date)
                                        ->where('status', 2)
                                        ->count();
            $success = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                                        ->whereDate('created_at',$start_date)
                                        ->where('status', 1)
                                        ->count();
            $canceled = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                                        ->whereDate('created_at',$start_date)
                                        ->where('status', 4)
                                        ->count();
            $hold = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                                        ->whereDate('created_at',$start_date)
                                        ->where('status', 3)
                                        ->count();
            $pending_data[]  = $pending;
            $success_data[]  = $success;
            $canceled_data[] = $canceled;
            $hold_data[]     = $hold;

            //Monthley virtual
            $card_pending = Transaction::where('type', PaymentGatewayConst::VIRTUALCARD)
                        ->whereDate('created_at',$start_date)
                        ->where('status', 2)
                        ->count();
            $card_success = Transaction::where('type', PaymentGatewayConst::VIRTUALCARD)
                        ->whereDate('created_at',$start_date)
                        ->where('status', 1)
                        ->count();
            $card_canceled = Transaction::where('type', PaymentGatewayConst::VIRTUALCARD)
                        ->whereDate('created_at',$start_date)
                        ->where('status', 4)
                        ->count();
            $card_hold = Transaction::where('type', PaymentGatewayConst::VIRTUALCARD)
                        ->whereDate('created_at',$start_date)
                        ->where('status', 3)
                        ->count();

            $card_pending_data[]  = $card_pending;
            $card_success_data[]  = $card_success;
            $card_canceled_data[] = $card_canceled;
            $card_hold_data[]    = $card_hold;

            // Event,Campaign,Gallery

            $event = Blog::where('status', 1)
            ->whereDate('created_at',$start_date)
            ->count();
            $event_data[]    = $event;
            $all_data[]      = $event ;

            $month_day[] = date('Y-m-d', $start);
            $start = strtotime('+1 day',$start);
        }
         // Donation
         $donation_balance = Transaction::toBase()->where('type', PaymentGatewayConst::TYPEADDMONEY)->where('status', 1)->sum('request_amount');
         $today_add_money_balance = Transaction::toBase()
                                     ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                     ->whereDate('created_at', $this_month_end)
                                     ->where('status', 1)
                                     ->sum('request_amount');
         $this_week_add_money_balance = Transaction::toBase()
                                     ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                     ->whereDate('created_at', '>=', $this_weak)
                                     ->where('status', 1)
                                     ->sum('request_amount');
         $this_month_add_money_balance = Transaction::toBase()
                                     ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                     ->whereDate('created_at', '>=', $this_month)
                                     ->where('status', 1)
                                     ->sum('request_amount');
         $this_year_add_money_balance = Transaction::toBase()
                                     ->where('type', PaymentGatewayConst::TYPEADDMONEY)
                                     ->whereDate('created_at', '>=', $this_year)
                                     ->where('status', 1)
                                     ->sum('request_amount');
        // Chart one
        $chart_one_data = [
            'pending_data'  => $pending_data,
            'success_data'  => $success_data,
            'canceled_data' => $canceled_data,
            'hold_data'     => $hold_data,
        ];
         // Chart two
         $chart_two_data = [
            'pending_data'  => $card_pending_data,
            'success_data'  => $card_success_data,
            'canceled_data' => $card_canceled_data,
            'hold_data'     => $card_hold_data,
        ];
         // Chart three
         $chart_three_data = [
            'event'         => $event_data,
            'all_data'      => $all_data,
        ];
        // Chart four | User analysis
        $chart_four = [$active_user, $banned_user,$unverified_user,$total_user];
           // Chart for Donation groth
        $chart_five = [round($today_add_money_balance), round($this_week_add_money_balance),round($this_month_add_money_balance),round($this_year_add_money_balance)];



        $data = [
            'add_money_balance'    => $add_money_balance,
            'today_add_money'      => $today_add_money,
            'last_month_add_money' => $last_month_add_money,
            'add_money_percent'    => $add_money_percent,

            'total_user'      => $total_user,
            'unverified_user' => $unverified_user,
            'active_user'     => $active_user,
            'user_percent'    => $user_percent,

            'pending_add_money_balance'    => $pending_add_money_balance,
            'today_pending_add_money'      => $today_pending_add_money,
            'last_month_pending_add_money' => $last_month_pending_add_money,
            'pending_add_money_percent'    => $pending_add_money_percent,

            'chart_one_data'   => $chart_one_data,
            'chart_two_data'   => $chart_two_data,
            'chart_three_data' => $chart_three_data,
            'chart_four_data'  => $chart_four,
            'chart_five_data'  => $chart_five,
            'month_day'        => $month_day,

            'transactions'        => $transactions
        ];

        return view('admin.sections.dashboard.index',compact(
            'page_title', 'data'
        ));

    }


    /**
     * Logout Admin From Dashboard
     * @return view
     */
    public function logout(Request $request) {

        $push_notification_setting = BasicSettingsProvider::get()->push_notification_config;

        if($push_notification_setting) {
            $method = $push_notification_setting->method ?? false;

            if($method == "pusher") {
                $instant_id     = $push_notification_setting->instance_id ?? false;
                $primary_key    = $push_notification_setting->primary_key ?? false;

                if($instant_id && $primary_key) {
                    $pusher_instance = new PushNotifications([
                        "instanceId"    => $instant_id,
                        "secretKey"     => $primary_key,
                    ]);

                    $pusher_instance->deleteUser("".Auth::user()->id."");
                }
            }

        }

        $admin = auth()->user();
        try{
            $admin->update([
                'last_logged_out'   => now(),
                'login_status'      => false,
            ]);
        }catch(Exception $e) {
            // Handle Error
        }

        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    /**
     * Function for clear admin notification
     */
    public function notificationsClear() {
        $admin = auth()->user();

        if(!$admin) {
            return false;
        }

        try{
            $admin->update([
                'notification_clear_at'     => now(),
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng! Please try again.']];
            return Response::error($error,null,404);
        }

        $success = ['success' => ['Notifications clear successfully!']];
        return Response::success($success,null,200);
    }
}
