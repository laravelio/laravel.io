<?php  namespace Lio\Articles\UseCases\Responses; 

use Lio\Articles\Article;

class EditArticleResponse
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
