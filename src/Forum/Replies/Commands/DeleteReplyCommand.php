<?php namespace Lio\Forum\Replies\Commands; 

use Lio\Forum\Replies\Reply;

class DeleteReplyCommand
{
    public $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }
}
