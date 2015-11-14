<?php
namespace Lio\Replies;

use Lio\Users\User;

final class EloquentReplyRepository implements ReplyRepository
{
    /**
     * @var \Lio\Replies\EloquentReply
     */
    private $model;

    /**
     * @param \Lio\Replies\EloquentReply $model
     */
    public function __construct(EloquentReply $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @return \Lio\Replies\Reply|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param \Lio\Replies\ReplyAble $relation
     * @param \Lio\Users\User $author
     * @param string $body
     * @return \Lio\Replies\Reply[]
     */
    public function create(ReplyAble $relation, User $author, $body)
    {
        $reply = $this->model->newInstance(compact('body'));
        $reply->author_id = $author->id();

        $relation->replyAble()->save($reply);

        return $reply;
    }

    /**
     * @param \Lio\Replies\Reply $reply
     * @param array $attributes
     * @return \Lio\Replies\Reply
     */
    public function update(Reply $reply, array $attributes = [])
    {
        $reply->update($attributes);

        return $reply;
    }

    /**
     * @param \Lio\Replies\Reply $reply
     */
    public function delete(Reply $reply)
    {
        $reply->delete();
    }
}
