<?php namespace Lio\Forum\Threads\Commands;

use Lio\Accounts\Member;
use Lio\Forum\Threads\Thread;

class DeleteThreadCommand
{
    public $thread;
    public $user;

    public function __construct(Thread $thread, Member $user)
    {
        $this->thread = $thread;
        $this->user = $user;
    }
} 
