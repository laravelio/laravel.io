<?php namespace Lio\Forum;

use Illuminate\Support\Collection;

class ReplyRepository extends \Lio\Core\EloquentRepository
{
    public function __construct(Reply $model)
    {
        $this->model = $model;
    }
}