<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Queue\SerializesModels;

class ReplyWasCreated
{
    use SerializesModels;

    /**
     * @var \App\Models\Reply
     */
    public $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }
}
