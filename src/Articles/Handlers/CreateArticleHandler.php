<?php namespace Lio\Articles\Handlers; 

use Lio\Articles\ArticleRepository;
use Lio\CommandBus\Handler;

class CreateArticleHandler implements Handler
{
    /**
     * @var Articles
     */
    private $articles;
    /**
     * @var \Lio\Articles\ArticleRepository
     */
    private $articleRepository;
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Articles $articles, ArticleRepository $articleRepository, Dispatcher $dispatcher)
    {
        $this->articles = $articles;
        $this->articleRepository = $articleRepository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $article = $this->articles->addArticle($command->author, $command->title, $command->content, $command->status, $command->laravelVersion, $command->tagIds);
        $this->articleRepository->save($article);
        $this->dispatcher->dispatch($this->articles->releaseEvents());
        return $article;
    }
}
