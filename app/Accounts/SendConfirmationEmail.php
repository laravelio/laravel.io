<?php

namespace Lio\Accounts;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class SendConfirmationEmail
{
    /**
     * @var \Illuminate\Mail\Mailer
     */
    private $mailer;

    /**
     * The view for the confirmation HTML email.
     *
     * @var string
     */
    protected $view = 'emails.confirmation';

    /**
     * @param \Illuminate\Mail\Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send a confirmation email to the user to verify his email address.
     *
     * @param \Lio\Accounts\User $user
     */
    public function send(User $user)
    {
        $this->mailer->send(
            $this->view,
            ['confirmationCode' => $user->confirmation_code],
            function (Message $message) use ($user) {
                $message->to($user->email);
                $message->subject('Verify your email address for your Laravel.io account');
            }
        );
    }
}
