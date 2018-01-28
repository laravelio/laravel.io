<?php

namespace App\Mail;

use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class EmailConfirmationEmail extends Mailable
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
        return $this->subject('Confirm your membership email address')
            ->markdown('emails.email_confirmation');
    }
}
