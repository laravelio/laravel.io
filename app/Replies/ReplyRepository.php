<?php
namespace Lio\Replies;

use Lio\Users\User;

interface ReplyRepository
{
    /**
     * @param int $id
     * @return \Lio\Replies\Reply|null
     */
    public function find($id);

    /**
     * @param \Lio\Replies\ReplyAble $relation
     * @param \Lio\Users\User $author
     * @param string $body
     * @return \Lio\Replies\Reply[]
     */
    public function create(ReplyAble $relation, User $author, $body);

    /**
     * @param \Lio\Replies\Reply $reply
     * @param array $attributes
     * @return \Lio\Replies\Reply
     */
    public function update(Reply $reply, array $attributes = []);

    /**
     * @param \Lio\Replies\Reply $reply
     */
    public function delete(Reply $reply);
}
