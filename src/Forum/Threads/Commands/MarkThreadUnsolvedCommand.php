<?php namespace Lio\Forum\Threads\Commands; 

use Lio\Forum\Threads\Thread;

class MarkThreadUnsolvedCommand
{
    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }
} 
