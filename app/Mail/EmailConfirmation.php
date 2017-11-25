<?php

namespace App\Mail;

use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirmation extends Mailable
{
    use SerializesModels;

    /**
     * @var \App\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Confirm your Laravel.io email address')
            ->markdown('emails.email_confirmation');
    }
}
