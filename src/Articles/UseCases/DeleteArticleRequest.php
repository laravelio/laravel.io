<?php namespace Lio\Articles\UseCases;

class DeleteArticleRequest
{
    public $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }
} 
