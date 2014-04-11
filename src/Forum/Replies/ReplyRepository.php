<?php namespace Lio\Forum\Replies;

use Lio\Core\EloquentRepository;

class ReplyRepository extends EloquentRepository
{
    public function __construct(Reply $model)
    {
        $this->model = $model;
    }

    public function getRecentByUser(User $user, $count = 5)
    {
        return $this->model->with('thread')->where('author_id', '=', $user->id)->orderBy('created_at', 'desc')->take($count)->get();
    }
}
