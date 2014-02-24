<?php namespace Lio\Articles;

use Lio\Accounts\User;

class ArticleCreator
{
    private $articles;
    private $responder;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function setResponder(ArticleCreatorResponder $responder)
    {
        $this->responder = $responder;
    }

    public function create(array $data, User $author, array $tagIds)
    {
        $article = $this->articles->getNew($data + ['author_id' => $author->id]);

        if ( ! $this->articles->save($article)) {
            return $this->failure($article->getErrors());
        }

        if ($tagIds) {
            $article->setTags($tagIds);
        }

        if ($this->needToPublish($data)) {
            $article->publish();
        }

        return $this->success($article);
    }

    private function failure($errors)
    {
        return $this->responder->articleCreationError($errors);
    }

    private function success(Article $article)
    {
        return $this->responder->articleCreated($article);
    }

    private function needToPublish($data)
    {
        return isset($data['status']) && $data['status'] == Article::STATUS_PUBLISHED;
    }
}
