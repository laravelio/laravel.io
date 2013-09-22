<?php namespace Lio\Blog;

use Lio\Core\EloquentBaseRepository;

class TagRepository extends EloquentBaseRepository
{
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }
}
