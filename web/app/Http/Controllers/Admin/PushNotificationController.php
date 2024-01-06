<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PushNotificationRecord;
use App\Models\User;
use App\Providers\Admin\BasicSettingsProvider;
use Pusher\PushNotifications\PushNotifications;


class PushNotificationController extends Controller
{

    /**
     * Display The configuration page of push notification
     *
     * @return view
     */
    public function configuration()
    {
        $page_title = "Setup Notification";
        $push_notification = BasicSettingsProvider::get()->push_notification_config ?? null;
        $broadcast_config   = BasicSettingsProvider::get()->broadcast_config ?? null;
        return view('admin.sections.push-notification.config', compact(
            'page_title',
            'push_notification',
            'broadcast_config'
        ));
    }

    /**
     * Display The Push Notification Send Page
     *
     * @return view
     *
     */
    public function index()
    {
        $page_title = "Send Notification";
        $notifications = PushNotificationRecord::orderByDesc("id")->paginate(10);
        return view('admin.sections.push-notification.send', compact(
            'page_title',
            'notifications',
        ));
    }

    /**
     * Function for send push notification
     * @param  \Illuminate\Http\Request  $request
     * @return method
     */
    public function send(Request $request) {
        $vlaidator = Validator::make($request->all(),[
            'title'     => 'required|string|max:40',
            'body'      => 'required|string|max:80',
        ]);

        $validated = $vlaidator->validate();

        $basic_settings = BasicSettingsProvider::get();
        if(!$basic_settings) {
            return back()->with(['error' => ['Opps! Basic settings not found!']]);
        }

        if(!$basic_settings->push_notification_config) {
            return back()->with(['error' => ['Sorry! You have to configure first to send push notification.']]);
        }

        $saved_method = $basic_settings->push_notification_config->method ?? null;

        if($saved_method == null) {
            return back()->with(['error' => ['Please configure your push notification with valid credentials.']]);
        }

        $methodDristribute = [
            'pusher'        => "sendNotificationWithPusher"
        ];

        if(!array_key_exists($saved_method,$methodDristribute)) {
            abort(404);
        }

        $distribute_method_name =$methodDristribute[$saved_method];

        return $this->$distribute_method_name($validated);


    }


    /**
     * Function for send push notification via Pusher(Message Bird)
     * @param array $data
     * @return back URL
     */
    public function sendNotificationWithPusher($data) {
        $basic_settings = BasicSettingsProvider::get();

        if(!$basic_settings) {
            return back()->with(['error' => ['Opps! Basic settings not found!']]);
        }

        $notification_config = $basic_settings->push_notification_config;

        if(!$notification_config) {
            return back()->with(['error' => ['Sorry! You have to configure first to send push notification.']]);
        }

        $instance_id    = $notification_config->instance_id ?? null;
        $primary_key    = $notification_config->primary_key ?? null;

        if($instance_id == null || $primary_key == null) {
            return back()->with(['error' => ['Sorry! You have to configure first to send push notification.']]);
        }

        $notification = new PushNotifications(
            array(
                "instanceId" => $notification_config->instance_id,
                "secretKey" => $notification_config->primary_key,
            )
        );

        $notification_data = [
            'title'     => $data['title'] ?? "",
            'body'      => $data['body'] ?? "",
            'icon'      => get_fav($basic_settings),
        ];

        // Get all users/admins ids
        $admins_id = Admin::all()->map(function($data) {
            return "admin-".$data->id. "";
        })->toArray();

        $users_id = User::all()->map(function($data){
            return "user-".$data->id. "";
        })->toArray();

        $publisher_ids = array_merge($users_id,$admins_id);
        $ids_plot = array_chunk($publisher_ids,900);

        try{
            foreach($ids_plot as $item) {
                $response = $notification->publishToUsers(
                    $item,
                    [
                        "web"   => [
                            "notification"      => $notification_data,
                        ],
                    ],
                );
                sleep(2);
            }
        }catch(Exception $e){
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        // Insert notification record to database
        try{
            $push_notification_record = [
                'method'        => "pusher",
                'response'      => $response,
                'message'       => $notification_data,
                'send_by'       => Auth::user()->id,
            ];
            PushNotificationRecord::create($push_notification_record);
        }catch(Exception $e) {
            return back()->with(['error' => ['Opps! Faild to store information.']]);
        }

        return back()->with(['success' => ['Notification sended successfully!']]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $vlaidator = Validator::make($request->all(),[
            'method'            => 'required|string|in:pusher',
            'instance_id'       => 'required_if:method,pusher',
            'primary_key'        => 'required_if:method,pusher',
        ]);

        $validated = $vlaidator->validate();

        $accept_fields = [
            'pusher'        => ['instance_id','primary_key'],
            'firebase'      => ['server_key'],
            'one-signal'    => ['server_key'],
        ];

        $data = [];
        foreach($validated as $form_input => $item) {
            foreach($accept_fields as $method_name => $values) {
                if($validated['method'] == $method_name) {
                    $data['method'] = $validated['method'];
                    foreach($values as $value) {
                        $data[$value]  = $validated[$value] ?? null;
                    }
                    break;
                }
            }
        }

        $basic_settings = BasicSettings::first();
        if(!$basic_settings) {
            return back()->with(['error' => ['Opps! Basic setting not found!']]);
        }

        try{
            // Update Push notification config
            $basic_settings->update([
                'push_notification_config' => $data,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Push notification configuration updated successfully!']]);
    }

}
