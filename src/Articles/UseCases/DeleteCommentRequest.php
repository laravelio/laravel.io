<?php namespace Lio\Articles\UseCases; 

class DeleteCommentRequest
{
    public $commentId;

    public function __construct($commentId)
    {
        $this->commentId = $commentId;
    }
} 
