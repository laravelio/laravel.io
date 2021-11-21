<?php

namespace App\Mail;

use App\Models\Reply;
use App\Models\Subscription;
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
    public $receiver;

    public function __construct(Reply $reply, Subscription $subscription, User $receiver)
    {
        $this->thread = $reply->replyAble();
        $this->reply = $reply;
        $this->subscription = $subscription;
        $this->receiver = $receiver;
    }

    public function build()
    {
        return $this->subject("Re: {$this->reply->replyAble()->subject()}")
            ->markdown('emails.new_reply');
    }
}
