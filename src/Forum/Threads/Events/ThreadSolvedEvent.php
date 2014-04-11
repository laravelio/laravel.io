<?php namespace Lio\Forum\Threads\Events;

use Lio\Forum\Replies\Reply;
use Lio\Forum\Threads\Thread;
use Mitch\EventDispatcher\Event;

class ThreadSolvedEvent implements Event
{
    /**
     * @var \Lio\Forum\Threads\Thread
     */
    public $thread;
    /**
     * @var \Lio\Forum\Replies\Reply
     */
    private $solution;

    public function __construct(Thread $thread, Reply $solution)
    {
        $this->thread = $thread;
        $this->solution = $solution;
    }

    public function getName()
    {
        return 'forum.thread_solved';
    }
}
