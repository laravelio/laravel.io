<?php namespace Lio\Articles\UseCases;

use Lio\Articles\Repositories\ArticleRepository;
use Lio\CommandBus\Handler;

class DeleteArticleHandler implements Handler
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
        $article = $this->articleRepository->getById($command->articleId);
        $this->articleRepository->delete($article);
        return new DeleteArticleResponse($article);
    }
}
