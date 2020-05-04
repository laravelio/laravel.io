<?php

namespace App\Jobs;

use App\Models\Article;
use App\User;

final class UnlikeArticle
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

    public function handle(): void
    {
        $this->article->dislikedBy($this->user);
    }
}
