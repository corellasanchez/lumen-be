<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\View;


class PasswordResetEmail extends Mailable
{    
    use Queueable, SerializesModels;       
   
    public function build()
    {
        return $this->view('email.reset-password');
        // ->from('hello@q-software.com', 'Q Software')->subject('Hello & Welcome!')->replyTo('hello@q-software.com', 'Q Software');
    }
}