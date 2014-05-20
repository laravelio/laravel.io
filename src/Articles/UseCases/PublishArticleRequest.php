<?php namespace Lio\Articles\UseCases; 

class PublishArticleRequest
{
    public $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }
} 
