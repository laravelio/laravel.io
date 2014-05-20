<?php namespace Lio\Articles\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ArticleRepository
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function save(Model $model);

    /**
     * @param $id
     * @return \Lio\Articles\Entities\Article
     */
    public function getById($id);

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function delete(Model $model);
}
