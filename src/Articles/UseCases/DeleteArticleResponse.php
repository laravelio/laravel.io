<?php namespace Lio\Articles\UseCases;

use Lio\Articles\Article;

class DeleteArticleResponse
{
    /**
     * @var \Lio\Articles\Article
     */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
} 
