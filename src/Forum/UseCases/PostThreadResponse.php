<?php namespace Lio\Forum\UseCases; 

use Lio\Forum\Threads\Thread;

class PostThreadResponse
{
    /**
     * @var \Lio\Forum\Threads\Thread
     */
    private $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }
} 
