<?php namespace Lio\Articles\UseCases; 

class UnpublishArticleRequest
{
    public $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }
} 
