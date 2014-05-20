<?php namespace Lio\Forum\UseCases; 

use Lio\Forum\Threads\Thread;

class PostThreadResponse
{
    /**
     * @var \Lio\Forum\Threads\Thread
     */
    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }
} 
