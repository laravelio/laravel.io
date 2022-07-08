<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThreadMarkedAsSpamNotification extends Notification
{
    use Queueable;

    public function __construct(private Thread $thread)
    {
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Thread '{$this->thread->subject()}' #{$this->thread->getKey()} was marked as spam by a few people")
                    ->line("There's a thread that may need your moderation")
                    ->action('Go to thread', route('thread', $this->thread->slug()))
                    ->line("Thank you, {$notifiable->name()}");
    }
}
