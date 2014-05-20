<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Entities\Comment;

class DeleteCommentResponse
{
    /**
     * @var \Lio\Articles\Entities\Comment
     */
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
} 
