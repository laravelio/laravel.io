<?php

namespace App\Notifications;

use App\User;
use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReply extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\thread
     */
    private $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(User $notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(User $notifiable)
    {
        $username = $notifiable->username();

        return [
            'icon' => 'fa fa-reply',
            'image' => $notifiable->gratavarUrl(50),
            'url' => route_to_reply_able($this->thread),
            'content' => sprintf('<a href="%s">%s</a> replied "%s"', route('profile', $username), $username, $this->thread->subject()),
        ];
    }
}
