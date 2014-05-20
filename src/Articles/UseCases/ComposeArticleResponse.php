<?php namespace Lio\Articles\UseCases;

use Lio\Articles\Entities\Article;

class ComposeArticleResponse
{
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
} 
