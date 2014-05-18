<?php namespace Lio\Articles\UseCases\Responses;

use Lio\Articles\Article;

class ComposeArticleResponse
{
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
} 
