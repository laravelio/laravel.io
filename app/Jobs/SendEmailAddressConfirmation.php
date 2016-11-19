<?php

namespace App\Jobs;

use App\Mail\ConfirmEmailAddress;
use App\Users\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;

class SendEmailAddressConfirmation
{
    use SerializesModels;

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
