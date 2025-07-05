<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $key = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key)
    {
        // setting Password reset key 
        $this->key = $key; 

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $key = $this->key;
        $data = compact('key');
        return $this->view('mails.forgot-password')->with($data);
    }
}
