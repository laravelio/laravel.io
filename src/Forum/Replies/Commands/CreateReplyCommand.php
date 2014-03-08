<?php namespace Lio\Forum\Replies\Commands; 

use Lio\Forum\Threads\Thread;

class CreateReplyCommand
{
    private $thread;
    private $body;
    private $author;

    public function __construct(Thread $thread, $body, User $author)
    {
        $this->thread = $thread;
        $this->body = $body;
        $this->author = $author;
    }
}
