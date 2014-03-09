<?php namespace Lio\Forum\Replies\Commands; 

use Lio\Accounts\User;
use Lio\Forum\Replies\Reply;

class DeleteReplyCommand
{
    public $reply;
    public $deleter;

    public function __construct(Reply $reply, User $deleter)
    {
        $this->reply = $reply;
        $this->deleter = $deleter;
    }
}
