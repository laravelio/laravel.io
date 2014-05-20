<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Repositories\CommentRepository;
use Lio\CommandBus\Handler;

class DeleteCommentHandler implements Handler
{
    /**
     * @var \Lio\Articles\Repositories\CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle($command)
    {
        $comment = $this->commentRepository->getById($command->commentId);
        $this->commentRepository->delete($comment);
        return new DeleteCommentResponse($comment);
    }
}
