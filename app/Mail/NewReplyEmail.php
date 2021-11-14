<?php

namespace App\Mail;

use App\Models\Reply;
use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Mail\Mailable;

final class NewReplyEmail extends Mailable
{
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

    /**
     * @var \App\Models\User
     */
    public $user;

    public function __construct(Thread $thread, Reply $reply, Subscription $subscription, User $user)
    {
        $this->thread = $thread;
        $this->reply = $reply;
        $this->subscription = $subscription;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject("Re: {$this->reply->replyAble()->subject()}")
            ->markdown('emails.new_reply');
    }
}
