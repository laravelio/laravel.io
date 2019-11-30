<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Models\Reply;
use App\User;

final class LikeReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(Reply $reply, User $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }

    /**
     * @throws \App\Exceptions\CannotLikeItem
     */
    public function handle(): void
    {
        if ($this->reply->isLikedBy($this->user)) {
            throw CannotLikeItem::alreadyLiked('reply');
        }

        $this->reply->likedBy($this->user);
    }
}
