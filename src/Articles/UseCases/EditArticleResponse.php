<?php  namespace Lio\Articles\UseCases;

use Lio\Articles\Article;

class EditArticleResponse
{
    /**
     * @var \Lio\Articles\Article
     */
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
} 
