<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Repositories\CommentRepository;
use Lio\CommandBus\Handler;

class EditCommentHandler implements Handler
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
        $comment->edit($command->content);
        $this->commentRepository->save($comment);
        return new EditCommentResponse($comment);
    }
}
