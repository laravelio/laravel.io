<?php namespace Lio\Forum\Replies\Commands; 

use Lio\Forum\Replies\Reply;

class UpdateReplyCommand
{
    public $reply;
    public $body;
    public $user;

    public function __construct(Reply $reply, $body, User $user)
    {
        $this->reply = $reply;
        $this->body = $body;
        $this->user = $user;
    }
}
