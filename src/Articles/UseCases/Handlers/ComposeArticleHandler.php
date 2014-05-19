<?php namespace Lio\Articles\UseCases\Handlers;

use Lio\Articles\Article;
use Lio\Articles\ArticleRepository;
use Lio\Articles\UseCases\Responses\ComposeArticleResponse;
use Lio\CommandBus\Handler;
use Mitch\EventDispatcher\Dispatcher;

class ComposeArticleHandler implements Handler
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
        $article = Article::compose(
            $command->author,
            $command->title,
            $command->content,
            $command->status,
            $command->laravelVersion,
            $command->tagIds
        );
        $this->articleRepository->save($article);
        $this->dispatcher->dispatch($article->releaseEvents());
        return new ComposeArticleResponse($article);
    }
}
