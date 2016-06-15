<?php

namespace Lio\Replies;

use Lio\Users\User;

interface ReplyRepository
{
    /**
     * @return \Lio\Replies\Reply|null
     */
    public function find(int $id);

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function create(ReplyAble $relation, User $author, string $body);

    public function update(Reply $reply, array $attributes = []): Reply;
    public function delete(Reply $reply);
}
