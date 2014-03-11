<?php namespace Lio\Forum\Replies\Handlers; 

use Lio\Core\Handler;
use Lio\Forum\Forum;
use Lio\Forum\Replies\ReplyRepository;
use Mitch\EventDispatcher\Dispatcher;

class CreateReplyHandler implements Handler
{
    private $forum;
    private $repository;
    private $dispatcher;

    public function __construct(Forum $forum, ReplyRepository $repository, Dispatcher $dispatcher)
    {
        $this->forum = $forum;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $reply = $this->forum->addThreadReply($command->thread, $command->body, $command->author);
        $this->repository->save($reply);
        $this->dispatcher->dispatch($this->forum->releaseEvents());
        return $reply;
    }
}
