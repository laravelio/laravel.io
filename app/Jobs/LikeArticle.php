<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Models\Article;
use App\User;

final class LikeArticle
{
    /**
     * @var \App\Models\Article
     */
    private $article;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(Article $article, User $user)
    {
        $this->article = $article;
        $this->user = $user;
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
