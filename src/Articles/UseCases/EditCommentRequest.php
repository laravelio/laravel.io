<?php namespace Lio\Articles\UseCases; 

class EditCommentRequest
{
    public $commentId;
    public $content;

    public function __construct($commentId, $content)
    {
        $this->commentId = $commentId;
        $this->content = $content;
    }
} 
