<?php namespace Lio\Articles\Commands; 

use Lio\Articles\Article;

class DeleteArticleCommand
{
    /**
     * @var \Lio\Articles\Article
     */
    public $article;

    public function __construct(Article $article) {
        $this->article = $article;
    }
} 
