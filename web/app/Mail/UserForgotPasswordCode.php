<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserForgotPasswordCode extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $pwdCode;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $pwdCode)
    {
        $this->username = $username;
        $this->pwdCode = $pwdCode;
    }

    public function build()
    {
        return $this->view('mail-templates.user._forgot_password')->with(['username' =>  $this->username, 'code' => $this->pwdCode]);
    }
}
