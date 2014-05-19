<?php namespace Lio\Articles\Events;

use Lio\Articles\Article;
use Mitch\EventDispatcher\Event;

class ArticleWasComposed implements Event
{
    /**
     * @var \Lio\Articles\Article
     */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getName()
    {
        return 'ArticleWasComposed';
    }
}
