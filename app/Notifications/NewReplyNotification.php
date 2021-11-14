<?php

namespace App\Notifications;

use App\Mail\NewReplyEmail;
use App\Models\Reply;
use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

final class NewReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\Thread
     */
    public $thread;

    /**
     * @var \App\Models\Reply
     */
    public $reply;

    /**
     * @var \App\Models\Subscription
     */
    public $subscription;

    public function __construct(Thread $thread, Reply $reply, Subscription $subscription)
    {
        $this->thread = $thread;
        $this->reply = $reply;
        $this->subscription = $subscription;
    }

    public function via(User $user)
    {
        return ['mail', 'database'];
    }

    public function toMail(User $user)
    {
        return (new NewReplyEmail($this->thread, $this->reply, $this->subscription, $user))
            ->to($user->emailAddress(), $user->name());
    }

    public function toDatabase(User $user)
    {
        return [
            'type' => 'new_reply',
            'reply' => $this->reply->id(),
            'replyable_id' => $this->reply->replyable_id,
            'replyable_type' => $this->reply->replyable_type,
            'replyable_subject' => $this->reply->replyAble()->replyAbleSubject(),
        ];
    }
}
