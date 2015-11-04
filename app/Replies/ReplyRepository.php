<?php
namespace Lio\Replies;

use Lio\Users\User;

interface ReplyRepository
{
    /**
     * @param \Lio\Replies\ReplyAble $relation
     * @param \Lio\Users\User $author
     * @param string $body
     * @return \Lio\Replies\Reply[]
     */
    public function create(ReplyAble $relation, User $author, $body);
}
