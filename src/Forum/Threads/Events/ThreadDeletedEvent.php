<?php namespace Lio\Forum\Threads\Events;

use Lio\Forum\Threads\Thread;
use Mitch\EventDispatcher\Event;

class ThreadDeletedEvent implements Event
{
    /**
     * @var \Lio\Forum\Threads\Thread
     */
    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function getName()
    {
        return 'forum.thread_deleted';
    }
}
