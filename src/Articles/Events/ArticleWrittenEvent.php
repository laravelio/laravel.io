<?php namespace Lio\Articles\Events;

use Lio\Articles\Article;
use Mitch\EventDispatcher\Event;

class ArticleWrittenEvent implements Event
{
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getName()
    {
        return 'ArticleWritten';
    }
}
