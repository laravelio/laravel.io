<?php namespace Lio\Blog;

use Lio\Core\EloquentBaseRepository;

class PostRepository extends EloquentBaseRepository
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }
}
