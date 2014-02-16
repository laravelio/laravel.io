<?php namespace Lio\Articles;
use Lio\Accounts\User;

/**
* This class can call the following methods on the observer object:
*
* articleValidationError($errors)
* articleCreated($thread)
*/
class ArticleCreator
{
    protected $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function create(ArticleCreatorObserver $observer, array $data, User $author, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $observer->articleCreationError($validator->getErrors());
        }
        return $this->createArticle($observer, $data + ['author_id' => $author->id]);
    }

    protected function createArticle($observer, $data)
    {
        $article = $this->articles->getNew($data);
        if ( ! $this->articles->save($article)) {
            return $observer->articleCreationError($article->getErrors());
        }
        return $observer->articleCreated($article);
    }
}
