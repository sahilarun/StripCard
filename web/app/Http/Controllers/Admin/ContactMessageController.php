<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Notifications\User\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    /**
     * Mehtod for show subscriber page
     * @method GET
     * @return Illuminate\Http\Request Response
     */
    public function index() {
        $page_title = "All Contact Message";
        $data = Contact::orderBy('id',"DESC")->paginate();

        return view('admin.sections.contact-message.index',compact(
            'page_title',
            'data',
        ));
    }

    /**
     * Mehtod mail to mail
     * @method POST
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Request Response
     */
    public function emailSend(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'data_id'    => 'required',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000'
        ]);

       if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('modal', 'email-contact-user-modal');
       }
       $validated = $validator->validated();

       $contact = Contact::findOrFail($validated['data_id']);


       try {
            Notification::send($contact, new SendMail((object) $validated));
       } catch (\Throwable $th) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
       }

       return back()->with(['success' => ['Email successfully sended']]);

    }


    /**
     * Mehtod for delete subscriber item
     * @method DELETE
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Request Response
     */
    public function delete(Request $request){
        $request->validate([
            'target'    => 'required|string',
        ]);

        $subscriber = Contact::findOrFail($request->target);

        try {
            $subscriber->delete();
        } catch (\Throwable $th) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Contact Message delete successfully!']]);
    }
}
