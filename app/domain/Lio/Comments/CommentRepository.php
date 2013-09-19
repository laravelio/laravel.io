<?php namespace Lio\Comments;

use Lio\Core\EloquentBaseRepository;

class CommentRepository extends EloquentBaseRepository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}