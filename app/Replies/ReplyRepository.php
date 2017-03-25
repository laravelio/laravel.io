<?php

namespace App\Replies;

use App\Users\User;

class ReplyRepository
{
    /**
     * @var \App\Replies\Reply
     */
    private $model;

    public function __construct(Reply $model)
    {
        $this->model = $model;
    }

    public function find(int $id): Reply
    {
        return $this->model->findOrFail($id);
    }

    public function create(ReplyData $data): Reply
    {
        $reply = $this->model->newInstance();
        $reply->body = $data->body();
        $reply->author_id = $data->author()->id();
        $reply->ip = $data->ip();

        $data->replyAble()->repliesRelation()->save($reply);

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

    public function deleteByAuthor(User $author)
    {
        $this->model->where('author_id', $author->id())->delete();
    }
}
