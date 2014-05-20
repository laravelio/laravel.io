<?php namespace Lio\Articles\UseCases; 

use Lio\CommandBus\Handler;
use Lio\Articles\Repositories\ArticleRepository;

class UnpublishArticleHandler implements Handler
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
        $article->unpublish();
        $this->articleRepository->save($article);
        return new UnpublishArticleResponse($article);
    }
}
