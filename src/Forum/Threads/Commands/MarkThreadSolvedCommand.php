<?php namespace Lio\Forum\Threads\Commands; 

use Lio\Forum\Replies\Reply;
use Lio\Forum\Threads\Thread;

class MarkThreadSolvedCommand
{
    public $thread;
    public $solution;

    public function __construct(Thread $thread, Reply $solution)
    {
        $this->thread = $thread;
        $this->solution = $solution;
    }
} 
