<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\User;

final class UnlikeArticle
{
    public function __construct(
        private Article $article,
        private User $user
    ) {
    }

    public function handle(): void
    {
        $this->article->dislikedBy($this->user);
    }
}
