<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Admin\Currency;
use App\Models\StripeVirtualCard;
use App\Models\Transaction;
use App\Models\UserSupportTicket;
use App\Models\VirtualCardApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected $api;
    public function __construct()
    {
        $cardApi = VirtualCardApi::first();
        $this->api =  $cardApi;
    }
    public function index()
    {
        $page_title = "Dashboard";
        $user = auth()->user();
        $baseCurrency = Currency::default();
        $transactions = Transaction::auth()->latest()->take(5)->get();
        $totalAddMoney = Transaction::auth()->addMoney()->where('status',1)->sum('request_amount');
        $virtualCards = StripeVirtualCard::where('user_id',$user->id)->where('status',true)->count();
        $active_tickets = UserSupportTicket::authTickets()->active()->count();

        return view('user.dashboard',compact(
            "page_title",
            "baseCurrency",
            "user",
            "transactions",
            'totalAddMoney',
            'virtualCards',
            'active_tickets'
        ));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index')->with(['success' => ['Logout Successfully!']]);
    }
    public function deleteAccount(Request $request) {
        $validator = Validator::make($request->all(),[
            'target'        => 'required',
        ]);

        $user = auth()->user();

        try{
            $user->delete();
            return redirect()->route('index')->with(['success' => ['User deleted successfully!']]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }


    }
}
