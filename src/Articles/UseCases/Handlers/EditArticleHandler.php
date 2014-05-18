<?php namespace Lio\Articles\UseCases\Handlers;

use Lio\Articles\ArticleRepository;
use Lio\CommandBus\Handler;
use Mitch\EventDispatcher\Dispatcher;

class EditArticleHandler implements Handler
{
    private $articleRepository;
    private $dispatcher;

    public function __construct(ArticleRepository $articleRepository, Dispatcher $dispatcher)
    {
        $this->articleRepository = $articleRepository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {

    }
}
