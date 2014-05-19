<?php namespace Lio\Articles; 

use Illuminate\Database\Eloquent\Model;

interface ArticleRepository
{
    /**
     * @param Model $model
     * @return mixed
     */
    public function save(Model $model);

    /**
     * @param  $id
     * @return \Lio\Articles\Article
     */
    public function requireById($id);

    /**
     * @param $model
     * @return mixed
     */
    public function delete(Model $model);
} 
