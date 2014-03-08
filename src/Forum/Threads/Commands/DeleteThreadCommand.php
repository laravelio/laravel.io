<?php namespace Lio\Forum\Threads\Commands; 

use Lio\Forum\Threads\Thread;

class DeleteThreadCommand
{
    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }
} 
