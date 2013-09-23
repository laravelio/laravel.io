<?php namespace Lio\Articles;

use Lio\Core\EloquentBaseRepository;
use Lio\Accounts\User;
use Lio\Tags\TagRepository;

class ArticleRepository extends EloquentBaseRepository
{
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function getAllPublishedByTagsPaginated($tags, $perPage = 10)
    {
        return $this->getAllPublishedByTagsQuery($tags)->paginate($perPage);
    }

    public function getAllPublishedByTagsQuery($tags)
    {
        $query = $this->model->with(['author'])
                             ->where('status', '=', Article::STATUS_PUBLISHED)
                             ->join('article_tag', 'articles.id', '=', 'article_tag.article_id')
                             ->orderBy('published_at', 'desc')
                             ->groupBy('articles.id');

        if ($tags) {
            $query->whereIn('article_tag.tag_id', $tags->lists('id'));
        }

        return $query;
    }

    public function getArticlesByAuthorPaginated(User $author, $perPage = 20)
    {
        return $this->getArticlesByAuthor($author)->paginate($perPage, 'articles.*');
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
