<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Entities\Comment;

class EditCommentResponse
{
    /**
     * @var \Lio\Articles\Entities\Comment
     */
    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
} 
