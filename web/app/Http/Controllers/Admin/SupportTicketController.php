<?php

namespace App\Http\Controllers\Admin;

use App\Constants\SupportTicketConst;
use App\Http\Controllers\Controller;
use App\Models\UserSupportChat;
use App\Models\UserSupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Response;
use Exception;
use App\Events\Admin\SupportConversationEvent;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "All Ticket";
        $support_tickets = UserSupportTicket::orderByDesc("id")->get();
        return view('admin.sections.support-ticket.index', compact(
            'page_title',
            'support_tickets',
        ));
    }


    /**
     * Display The Pending List of Support Ticket
     *
     * @return view
     */
    public function pending() {
        $page_title = "Pending Ticket";
        $support_tickets = UserSupportTicket::pending()->orderByDesc("id")->get();
        return view('admin.sections.support-ticket.index', compact(
            'page_title',
            'support_tickets'
        ));
    }


    /**
     * Display The Active List of Support Ticket
     *
     * @return view
     */
    public function active() {
        $page_title = "Active Ticket";
        $support_tickets = UserSupportTicket::active()->orderByDesc("id")->get();
        return view('admin.sections.support-ticket.index', compact(
            'page_title',
            'support_tickets',
        ));
    }


    /**
     * Display The Solved List of Support Ticket
     *
     * @return view
     */
    public function solved() {
        $page_title = "Solved Ticket";
        $support_tickets = UserSupportTicket::solved()->orderByDesc("id")->get();
        return view('admin.sections.support-ticket.index', compact(
            'page_title',
            'support_tickets',
        ));
    }


    public function conversation($encrypt_id) {
        $support_ticket_id = decrypt($encrypt_id);
        $support_ticket = UserSupportTicket::findOrFail($support_ticket_id);
        $page_title = "Support Chat";
        return view('admin.sections.support-ticket.conversation',compact(
            'page_title',
            'support_ticket',
        ));
    }


    public function messageReply(Request $request) {
        $validator = Validator::make($request->all(),[
            'message'       => 'required|string|max:200',
            'support_token' => 'required|string|exists:user_support_tickets,token',
        ]);
        if($validator->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->validate();

        $support_ticket = UserSupportTicket::notSolved($validated['support_token'])->first();
        if(!$support_ticket) return Response::error(['error' => ['This support ticket is closed.']]);

        $data = [
            'user_support_ticket_id'    => $support_ticket->id,
            'sender'                    => auth()->user()->id,
            'sender_type'               => "ADMIN",
            'message'                   => $validated['message'],
            'receiver_type'             => "USER",
            'receiver'                  => $support_ticket->user_id,
        ];

        try{
            $chat_data = UserSupportChat::create($data);
        }catch(Exception $e) {
            $error = ['error' => ['SMS Sending faild! Please try again.']];
            return Response::error($error,null,500);
        }

        try{
            event(new SupportConversationEvent($support_ticket,$chat_data));
        }catch(Exception $e) {
            $error = ['error' => ['SMS Sending faild! Please try again.']];
            return Response::error($error,null,500);
        }

        if($support_ticket->status != SupportTicketConst::ACTIVE) {
            try{
                $support_ticket->update([
                    'status'    => SupportTicketConst::ACTIVE,
                ]);
            }catch(Exception $e) {
                $error = ['error' => ['Faild to change status to active!']];
                return Response::error($error,null,500);
            }
        }
    }


    public function solve(Request $request) {
        $validator = Validator::make($request->all(),[
            'target'    => 'required|string|exists:user_support_tickets,token',
        ]);
        $validated = $validator->validate();

        $support_ticket = UserSupportTicket::where("token",$validated['target'])->first();
        if($support_ticket->status == SupportTicketConst::SOLVED) return back()->with(['warning' => ['This ticket is already solved!']]);

        try{
            $support_ticket->update([
                'status'        => SupportTicketConst::SOLVED,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Mark as solved success']]);
    }
}
