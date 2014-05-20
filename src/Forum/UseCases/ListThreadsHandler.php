<?php namespace Lio\Forum\UseCases; 

use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;
use Lio\Forum\ThreadRepository;

class ListThreadsHandler implements Handler
{
    /**
     * @var \Lio\Events\Dispatcher
     */
    private $dispatcher;
    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threadRepository;

    public function __construct(Dispatcher $dispatcher, ThreadRepository $threadRepository)
    {
        $this->dispatcher = $dispatcher;
        $this->threadRepository = $threadRepository;
    }

    public function handle($request)
    {
        $threads = $this->threadRepository->getPageByTagsAndStatus($request->tags, $request->status, $request->page, $request->threadsPerPage);
        return new ListThreadsResponse($threads);
    }
}
