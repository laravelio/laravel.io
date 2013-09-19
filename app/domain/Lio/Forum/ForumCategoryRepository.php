<?php namespace Lio\Forum;

use Lio\Core\EloquentBaseRepository;

class ForumCategoryRepository extends EloquentBaseRepository
{
    public function __construct(ForumCategory $model)
    {
        $this->model = $model;
    }

    public function getForumIndex()
    {
        return $this->model->where('show_in_index', '=', 1)->get();
    }
}