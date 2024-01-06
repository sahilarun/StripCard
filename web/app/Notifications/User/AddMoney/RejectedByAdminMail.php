<?php

namespace App\Notifications\User\AddMoney;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class RejectedByAdminMail extends Notification
{
    use Queueable;

    public $user;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$data)
    {
        $this->user = $user;
        $this->data = $data;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $this->user;
        $data = $this->data;
        $date = Carbon::now();
        $dateTime = $date->format('Y-m-d h:i:s A');
        return (new MailMessage)
                    ->greeting("Hello ".$user->fullname." !")
                    ->subject("Add Money Via ". @$data->currency->name)
                    ->line("Your add money request via ".@$data->currency->name." rejected by admin, details of add money:")
                    ->line("Request Amount: " . getAmount($data->request_amount,2).' '. get_default_currency_code())
                    ->line("Exchange Rate: " ." 1 ". get_default_currency_code().' = '. getAmount(@$data->currency->rate,2).' '.@$data->currency->currency_code)
                    ->line("Fees & Charges: " .getAmount( @$data->charge->total_charge,2).' '. @$data->currency->currency_code)
                    ->line("Will Get: " . getAmount(@$data->request_amount,2).' '. get_default_currency_code())
                    ->line("Total Payable Amount: " . getAmount(@$data->payable,2).' '. @$data->currency->currency_code)
                    ->line("Transaction Id: " .@$data->trx_id)
                    ->line("Status: Rejected")
                    ->line("Rejected Reson: " .@$data->reject_reason)
                    ->line("Date And Time: " .@$dateTime)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
