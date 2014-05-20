<?php namespace Lio\Articles;

use Illuminate\Database\Eloquent\Model;
use Lio\Articles\Repositories\ArticleRepository;

class StubbedArticleRepository implements ArticleRepository
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function save(Model $model)
    {
    }

    /**
     * @param $id
     * @return \Lio\Articles\Entities\Article
     */
    public function getById($id)
    {
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function delete(Model $model)
    {
    }
}
