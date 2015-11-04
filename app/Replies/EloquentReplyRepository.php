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
     * @param \Lio\Replies\ReplyAble $relation
     * @param \Lio\Users\User $author
     * @param string $body
     * @return \Lio\Replies\Reply[]
     */
    public function create(ReplyAble $relation, User $author, $body)
    {
        $reply = $this->model->newInstance();
        $reply->author_id = $author->id();
        $reply->body = $body;

        $relation->replyable()->save($reply);

        return $reply;
    }
}
