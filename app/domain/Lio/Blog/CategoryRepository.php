<?php namespace Lio\Blog;

use Lio\Core\EloquentBaseRepository;

class CategoryRepository extends EloquentBaseRepository
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}
