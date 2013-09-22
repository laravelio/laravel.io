<?php namespace Lio\Articles;

use Lio\Core\EloquentBaseRepository;

class ArticleRepository extends EloquentBaseRepository
{
    public function __construct(Article $model)
    {
        $this->model = $model;
    }
}
