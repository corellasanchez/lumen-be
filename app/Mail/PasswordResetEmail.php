<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\View;

use App\Models\User;


class PasswordResetEmail extends Mailable
{    
    use Queueable, SerializesModels;  
    
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
   
    public function build()
    {
        return $this->view('email.reset-password');
        // ->from('hello@q-software.com', 'Q Software')->subject('Hello & Welcome!')->replyTo('hello@q-software.com', 'Q Software');
    }
}