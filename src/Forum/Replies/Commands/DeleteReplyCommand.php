<?php namespace Lio\Forum\Replies\Commands;

use Lio\Accounts\User;
use Lio\Forum\Replies\Reply;

class DeleteReplyCommand
{
    public $reply;
    public $user;

    public function __construct(Reply $reply, User $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }
}
