<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    protected $username = '';
    protected $email = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $email)
    {
        $this->username = $username; 
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $username = $this->username;
        $email = $this->email;
        $hash = md5($email);
        $data = compact('username', 'email','hash');
        return $this->view('mails.email-verify')->with($data);
    }
}
