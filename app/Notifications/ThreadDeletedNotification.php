<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThreadDeletedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Thread $thread,
        public ?string $reason = null,
    ) {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("The thread '{$this->thread->subject()}' #{$this->thread->getKey()} was deleted by the moderator")
                    ->line('with the following reasons:')
                    ->line($this->reason)
                    ->line('Thank you');
    }
}
