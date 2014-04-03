<?php namespace Lio\Articles\Events; 

use Lio\Articles\Article;
use Mitch\EventDispatcher\Event;

class ArticleCreatedEvent implements Event
{
    /**
     * @var \Lio\Articles\Article
     */
    public $article;

    public function __construct(Article $article) {
        $this->article = $article;
    }

    public function getName()
    {
        return 'ArticleCreated';
    }
}
