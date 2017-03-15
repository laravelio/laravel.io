<?php

namespace Lio\Forum\Replies;

class ReplyRepository extends \Lio\Core\EloquentRepository
{
    public function __construct(Reply $model)
    {
        $this->model = $model;
    }
}
