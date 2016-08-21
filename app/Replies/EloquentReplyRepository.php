<?php

namespace App\Replies;

use Illuminate\Support\Arr;
use App\Users\User;

final class EloquentReplyRepository implements ReplyRepository
{
    /**
     * @var \App\Replies\EloquentReply
     */
    private $model;

    public function __construct(EloquentReply $model)
    {
        $this->model = $model;
    }

    public function find(int $id): Reply
    {
        return $this->model->findOrFail($id);
    }

    public function create(ReplyAble $relation, User $author, string $body, array $attributes = []): Reply
    {
        $reply = $this->model->newInstance(compact('body'));
        $reply->author_id = $author->id();
        $reply->ip = Arr::get($attributes, 'ip', '');

        $relation->replyAble()->save($reply);

        return $reply;
    }

    public function update(Reply $reply, array $attributes = []): Reply
    {
        $reply->update($attributes);

        return $reply;
    }

    public function delete(Reply $reply)
    {
        $reply->delete();
    }
}
