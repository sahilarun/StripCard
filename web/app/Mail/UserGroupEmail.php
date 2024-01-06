<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserGroupEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $email;
    public $mail_body;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $subject, $mail_body)
    {
        $this->subject = $subject;
        $this->first_name = $first_name;
        $this->mail_body = $mail_body;
    }

    public function build()
    {
        return $this->view('mail-templates.user._user_batch_mail')->with(['name' =>  $this->first_name, $this->subject, $this->mail_body]);
    }
}
