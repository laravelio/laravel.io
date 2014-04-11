<?php namespace Lio\Articles\Commands;

use Lio\Articles\Article;

class UpdateArticleCommand
{
    /**
     * @var \Lio\Articles\Article
     */
    public $article;
    public $title;
    public $content;
    public $status;
    public $laravelVersion;
    public $tags;

    public function __construct(Article $article, $title, $content, $status, $laravelVersion, $tags){
        $this->article = $article;
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
        $this->laravelVersion = $laravelVersion;
        $this->tags = $tags;
    }
} 
