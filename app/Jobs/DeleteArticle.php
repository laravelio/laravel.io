<?php

namespace App\Jobs;

use App\Models\Article;

final class DeleteArticle
{
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle()
    {
        $this->article->delete();
    }
}
