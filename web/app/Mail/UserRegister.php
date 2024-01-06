<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $code)
    {
        $this->first_name = $first_name;
        $this->code = $code;
    }

    public function build()
    {
        return $this->view('mail-templates.user._registration')->with(['name' =>  $this->first_name, 'code' => $this->code]);
    }
}
