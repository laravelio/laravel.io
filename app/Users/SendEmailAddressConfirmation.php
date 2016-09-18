<?php

namespace App\Users;

use Illuminate\Contracts\Mail\Mailer;

class SendEmailAddressConfirmation
{
    /**
     * @var \App\Users\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(Mailer $mailer)
    {
        $mailer->to($this->user->emailAddress())
            ->send(new ConfirmEmailAddress($this->user));
    }
}
