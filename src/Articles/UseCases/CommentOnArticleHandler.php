<?php namespace Lio\Articles\UseCases; 

use Lio\Articles\Repositories\CommentRepository;
use Lio\CommandBus\Handler;
use Lio\Articles\Repositories\ArticleRepository;

class CommentOnArticleHandler implements Handler
{
    /**
     * @var \Lio\Articles\Repositories\ArticleRepository
     */
    private $articleRepository;
    /**
     * @var \Lio\Articles\Repositories\CommentRepository
     */
    private $commentRepository;

    public function __construct(ArticleRepository $articleRepository, CommentRepository $commentRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
    }

    public function handle($command)
    {
        $article = $this->articleRepository->getById($command->articleId);
        $comment = $article->placeComment($command->author, $command->content);
        $this->articleRepository->save($article);
        return new CommentOnArticleResponse($article, $comment);
    }
}
