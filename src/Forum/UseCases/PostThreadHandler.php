<?php namespace Lio\Forum\UseCases; 

use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;
use Lio\Forum\ThreadRepository;
use Lio\Forum\Threads\Thread;

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
        $thread = Thread::register(
            $request->member,
            $request->subject,
            $request->body,
            $request->isQuestion,
            $request->laravelVersion,
            $request->tagIds
        );

        $this->threadRepository->save($thread);
        return new PostThreadResponse($thread);
    }
}
