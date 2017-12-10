<?php

namespace App\Notifications;

use App\Mail\NewReplyEmail;
use App\Models\Reply;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\Reply
     */
    public $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function via(User $user)
    {
        return ['mail'];
    }

    public function toMail(User $user)
    {
        return (new NewReplyEmail($this->reply))
            ->to($user->emailAddress(), $user->name());
    }

    public function toArray(User $user)
    {
        return [
            //
        ];
    }
}
