<?php namespace Lio\Forum\UseCases; 

use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;
use Lio\Forum\ThreadRepository;

class PostThreadHandler implements Handler
{
    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threadRepository;
    /**
     * @var \Lio\Events\Dispatcher
     */
    private $dispatcher;

    public function __construct(ThreadRepository $threadRepository, Dispatcher $dispatcher)
    {
        $this->threadRepository = $threadRepository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($request)
    {

    }
}
