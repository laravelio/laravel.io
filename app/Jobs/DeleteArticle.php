<?php

namespace App\Jobs;

use App\Models\Article;

final class DeleteArticle
{
    public function __construct(
        private Article $article
    ) {
    }

    public function handle()
    {
        $this->article->delete();
    }
}
