<?php

namespace App\Notifications;

use App\Mail\ThreadDeletedEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ThreadDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $threadSubject, public ?string $reason = null) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $user): ThreadDeletedEmail
    {
        return (new ThreadDeletedEmail($this->threadSubject, $this->reason))
            ->to($user->emailAddress(), $user->name());
    }
}
