<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Models\Reply;
use App\Models\User;

final class LikeReply
{
    public function __construct(
        private Reply $reply,
        private User $user
    ) {
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
