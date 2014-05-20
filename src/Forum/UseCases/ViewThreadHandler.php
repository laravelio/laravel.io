<?php namespace Lio\Forum\UseCases; 

use Lio\CommandBus\Handler;
use Lio\Core\Exceptions\EntityNotFoundException;
use Lio\Events\Dispatcher;
use Lio\Forum\ReplyRepository;
use Lio\Forum\ThreadRepository;

class ViewThreadHandler implements Handler
{
    /**
     * @var \Lio\Events\Dispatcher
     */
    private $dispatcher;
    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threadRepository;
    /**
     * @var \Lio\Forum\ReplyRepository
     */
    private $replyRepository;

    public function __construct(Dispatcher $dispatcher, ThreadRepository $threadRepository, ReplyRepository $replyRepository)
    {
        $this->dispatcher = $dispatcher;
        $this->threadRepository = $threadRepository;
        $this->replyRepository = $replyRepository;
    }

    public function handle($request)
    {
        $thread = $this->threadRepository->getBySlug($request->slug);

        if ( ! $thread) {
            throw new EntityNotFoundException;
        }

        $replies = $this->replyRepository->getRepliesForThread($thread, $request->page, $request->repliesPerPage);

        return new ViewThreadResponse($thread, $replies);
    }
}
