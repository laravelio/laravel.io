<?php

namespace App\Jobs;

use App\Models\Article;

final class DeclineArticle
{
    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        $this->article->declined_at = now();
        $this->article->save();

        return $this->article;
    }
}
