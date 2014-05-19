<?php namespace Lio\Articles\UseCases;

class DeleteArticleRequest
{
    private $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }
} 
