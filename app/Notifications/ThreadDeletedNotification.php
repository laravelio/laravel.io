<?php

namespace App\Notifications;

use App\Mail\ThreadDeletedEmail;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ThreadDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Thread $thread, public ?string $reason = null)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(User $user)
    {
        return (new ThreadDeletedEmail($this->thread, $this->reason))
            ->to($user->emailAddress(), $user->name());
    }
}
