<?php

namespace App\Jobs;

use App\Models\Article;

final class DisapproveArticle
{
    public function __construct(
        private Article $article
    ) {
    }

    public function handle(): Article
    {
        $this->article->approved_at = null;
        $this->article->save();

        return $this->article;
    }
}
