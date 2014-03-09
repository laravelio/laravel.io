<?php namespace Lio\Forum\Threads\Commands; 

use Lio\Forum\Threads\Thread;

class MarkThreadUnsolvedCommand
{
    public $thread;
    public $user;

    public function __construct(Thread $thread, User $user)
    {
        $this->thread = $thread;
        $this->user = $user;
    }
} 
