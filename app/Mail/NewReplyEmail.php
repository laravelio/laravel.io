<?php

namespace App\Mail;

use App\Models\Reply;
use App\Models\Subscription;
use Illuminate\Mail\Mailable;

final class NewReplyEmail extends Mailable
{
    /**
     * @var \App\Models\Reply
     */
    public $reply;

    /**
     * @var \App\Models\Subscription
     */
    public $subscription;

    public function __construct(Reply $reply, Subscription $subscription)
    {
        $this->reply = $reply;
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject("Re: {$this->reply->replyAble()->subject()}")
            ->markdown('emails.new_reply');
    }
}
