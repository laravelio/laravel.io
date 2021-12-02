<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Models\Article;
use App\Models\User;

final class LikeArticle
{
    public function __construct(
        private Article $article,
        private User $user
    ) {
    }

    /**
     * @throws \App\Exceptions\CannotLikeItem
     */
    public function handle(): void
    {
        if ($this->article->isLikedBy($this->user)) {
            throw CannotLikeItem::alreadyLiked('article');
        }

        $this->article->likedBy($this->user);
    }
}
