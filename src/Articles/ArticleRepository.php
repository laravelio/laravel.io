<?php namespace Lio\Articles;

use Illuminate\Database\Eloquent\Model;
use Lio\Core\EloquentRepository;
use Lio\Core\Exceptions\EntityNotFoundException;

class ArticleRepository extends EloquentRepository
{
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function requirePublishedArticleBySlug($slug)
    {
        $model = $this->getPublishedArticleBySlug($slug);

        if ( ! $model) {
            throw new EntityNotFoundException('Could not find article by slug "'.$slug.'".');
        }

        return $model;
    }

    public function getPublishedArticleBySlug($slug)
    {
        return $this->model->with('author')
            ->where('slug', '=', $slug)
            ->where('status', '=', Article::STATUS_PUBLISHED)
            ->first();
    }

    public function getAllPublishedByTagsPaginated($tags, $perPage = 10)
    {
        return $this->getAllPublishedByTagsQuery($tags)->paginate($perPage, ['articles.*']);
    }

    public function getAllPublishedByTagsQuery($tags)
    {
        $query = $this->model->with(['author'])
                             ->where('status', '=', Article::STATUS_PUBLISHED)
                             ->join('article_tag', 'articles.id', '=', 'article_tag.article_id')
                             ->orderBy('published_at', 'desc')
                             ->groupBy('articles.id');

        if ($tags->count() > 0) {
            $query->whereIn('article_tag.tag_id', $tags->lists('id'));
        }

        return $query;
    }

    public function save(Model $model)
    {
        $model->save();
        if ($model->hasUpdatedTags()) {
            $model->tags()->sync($model->getUpdatedTagIds());
        }
    }
}
