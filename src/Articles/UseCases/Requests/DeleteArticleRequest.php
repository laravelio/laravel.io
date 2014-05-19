<?php namespace Lio\Articles\UseCases\Requests; 

class DeleteArticleRequest
{
    private $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }
} 
