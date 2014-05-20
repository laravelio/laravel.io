<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Entities\Article;
use Lio\Articles\Entities\Comment;

class CommentOnArticleResponse
{
    /**
     * @var \Lio\Articles\Entities\Article
     */
    private $article;
    /**
     * @var \Lio\Articles\Entities\Comment
     */
    private $comment;

    public function __construct(Article $article, Comment $comment)
    {
        $this->article = $article;
        $this->comment = $comment;
    }
} 
