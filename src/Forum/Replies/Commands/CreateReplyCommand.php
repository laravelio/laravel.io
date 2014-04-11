<?php namespace Lio\Forum\Replies\Commands;

use Lio\Accounts\User;
use Lio\Forum\Threads\Thread;

class CreateReplyCommand
{
    public $thread;
    public $body;
    public $author;

    public function __construct(Thread $thread, $body, User $author)
    {
        $this->thread = $thread;
        $this->body = $body;
        $this->author = $author;
    }
}
