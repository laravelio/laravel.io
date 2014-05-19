<?php namespace Lio\Articles\UseCases;

use Lio\Articles\ArticleRepository;
use Lio\CommandBus\Handler;

class DeleteArticleHandler implements Handler
{
    /**
     * @var \Lio\Articles\ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle($command)
    {
        $article = $this->articleRepository->requireById($command->articleId);
        $this->articleRepository->delete($article);
        return new DeleteArticleResponse($article);
    }
}
