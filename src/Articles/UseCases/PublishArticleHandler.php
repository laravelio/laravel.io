<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Repositories\ArticleRepository;
use Lio\CommandBus\Handler;

class PublishArticleHandler implements Handler
{
    /**
     * @var \Lio\Articles\Repositories\ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle($command)
    {
        $article = $this->articleRepository->getBySlug($command->$articleId);
        $article->publish();
        $this->articleRepository->save($article);
        return new PublishArticleResponse($article);
    }
}
