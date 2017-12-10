<?php

namespace App\Mail;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReplyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Reply
     */
    public $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject("Re: {$this->reply->replyAble()->subject()}")
            ->markdown('emails.new_reply');
    }
}
