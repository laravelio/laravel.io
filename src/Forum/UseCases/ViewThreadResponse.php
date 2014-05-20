<?php namespace Lio\Forum\UseCases; 

use Lio\Forum\Threads\Thread;

class ViewThreadResponse
{
    /**
     * @var \Lio\Forum\Threads\Thread
     */
    public $thread;
    public $replies;

    public function __construct(Thread $thread, $replies)
    {
        $this->thread = $thread;
        $this->replies = $replies;
    }
} 
