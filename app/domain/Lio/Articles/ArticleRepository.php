<?php namespace Lio\Articles;

use Lio\Core\EloquentBaseRepository;
use Lio\Accounts\User;

class ArticleRepository extends EloquentBaseRepository
{
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function getArticlesByAuthorPaginated(User $author, $perPage = 20)
    {
        return $this->getArticlesByAuthor($author)->paginate($perPage);
    }

    public function getArticlesByAuthor(User $author)
    {
        return $author->articles()->orderBy('articles.status', 'asc')->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }

    public function getArticleForm()
    {
        return new ArticleForm;
    }
}
