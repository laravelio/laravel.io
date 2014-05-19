<?php namespace Lio\Articles\UseCases;

use Lio\Articles\Article;
use Lio\Articles\ArticleRepository;
use Lio\CommandBus\Handler;

class ComposeArticleHandler implements Handler
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
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
        return new ComposeArticleResponse($article);
    }
}
