<?php namespace Lio\Bin;

use Lio\Core\EloquentBaseRepository;

class CommentRepository extends EloquentBaseRepository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}
