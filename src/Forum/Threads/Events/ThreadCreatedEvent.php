<?php namespace Lio\Forum\Threads\Events; 

use Lio\Forum\Threads\Thread;
use Mitch\EventDispatcher\Event;

class ThreadCreatedEvent implements Event
{
    /**
     * @var \Lio\Forum\Threads\Thread
     */
    public $thread;
    /**
     * @var array
     */
    public $tagIds;

    public function __construct(Thread $thread, array $tagIds = [])
    {
        $this->thread = $thread;
        $this->tagIds = $tagIds;
    }

    public function getName()
    {
        return 'forum.thread_created';
    }
}
