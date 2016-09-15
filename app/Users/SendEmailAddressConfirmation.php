<?php

namespace App\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailAddressConfirmation
{
    use InteractsWithQueue, Queueable, SerializesModels;

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
