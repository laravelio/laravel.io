<?php

namespace App\Jobs;

use App\Models\Article;

final class DeclineArticle
{
    public function __construct(
        private Article $article
    ) {
    }

    public function handle(): void
    {
        $this->article->declined_at = now();
        $this->article->save();
    }
}
