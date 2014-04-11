<?php namespace Lio\Forum\Threads\Commands;

use Lio\Accounts\User;
use Lio\Forum\Threads\Thread;

class UpdateThreadCommand
{
    public $thread;
    public $subject;
    public $body;
    public $user;
    public $isQuestion;
    public $laravelVersion;
    public $tagIds;

    public function __construct(Thread $thread, $subject, $body, User $user, $isQuestion, $laravelVersion, array $tagIds)
    {
        $this->thread = $thread;
        $this->subject = $subject;
        $this->body = $body;
        $this->user = $user;
        $this->isQuestion = $isQuestion;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
} 
