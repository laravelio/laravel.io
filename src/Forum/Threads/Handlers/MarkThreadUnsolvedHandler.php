<?php namespace Lio\Forum\Threads\Handlers;

use Lio\Core\Handler;
use Lio\Forum\Forum;
use Lio\Forum\EloquentThreadRepository;
use Mitch\EventDispatcher\Dispatcher;

class MarkThreadUnsolvedHandler implements Handler
{
    /**
     * @var \Lio\Forum\Forum
     */
    private $forum;
    /**
     * @var \Lio\Forum\EloquentThreadRepository
     */
    private $repository;
    /**
     * @var \Mitch\EventDispatcher\Dispatcher
     */
    private $dispatcher;

    public function __construct(Forum $forum, EloquentThreadRepository $repository, Dispatcher $dispatcher)
    {
        $this->forum = $forum;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $thread = $this->forum->markThreadUnsolved($command->thread);
        $this->repository->save($thread);
        $this->dispatcher->dispatch($this->forum->releaseEvents());
        return $thread;
    }
}
