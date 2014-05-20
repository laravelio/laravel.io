<?php namespace Lio\Articles\UseCases;

use Lio\Articles\Entities\Article;

class EditArticleResponse
{
    /**
     * @var \Lio\Articles\Entities\Article
     */
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
} 
