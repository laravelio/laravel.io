<?php namespace Lio\Forum\Replies\Commands; 

use Lio\Forum\Replies\Reply;

class UpdateReplyCommand
{
    public $reply;
    public $body;

    public function __construct(Reply $reply, $body)
    {
        $this->reply = $reply;
        $this->body = $body;
    }
}
