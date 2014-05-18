<?php namespace Lio\Forum\Threads\Commands;

use Lio\Accounts\Member;
use Lio\Forum\Replies\Reply;
use Lio\Forum\Threads\Thread;

class MarkThreadSolvedCommand
{
    public $thread;
    public $solution;
    public $user;

    public function __construct(Thread $thread, Reply $solution, Member $user)
    {
        $this->thread = $thread;
        $this->solution = $solution;
        $this->user = $user;
    }
} 
