<?php

namespace App\Mail;

use App\Models\Reply;
use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Mail\Mailable;

final class NewReplyEmail extends Mailable
{
    public Thread $thread;

    public function __construct(
        public Reply $reply,
        public Subscription $subscription,
        public User $receiver
    ) {
        $this->thread = $reply->replyAble();
    }

    public function build()
    {
        return $this->subject("Re: {$this->reply->replyAble()->subject()}")
            ->markdown('emails.new_reply');
    }
}
