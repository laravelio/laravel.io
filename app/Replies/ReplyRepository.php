<?php

namespace App\Replies;

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

    public function create(NewReply $data): Reply
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
}
