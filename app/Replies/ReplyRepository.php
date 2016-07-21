<?php

namespace Lio\Replies;

use Lio\Users\User;

interface ReplyRepository
{
    public function find(int $id): Reply;
    public function create(ReplyAble $relation, User $author, string $body, array $attributes = []): Reply;
    public function update(Reply $reply, array $attributes = []): Reply;
    public function delete(Reply $reply);
}
