<?php

namespace App\Jobs;

use App\Models\Article;

final class DeclineArticle
{
    /**
     * @var \App\Models\Article
     */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): Article
    {
        $this->article->declined_at = now();
        $this->article->save();

        return $this->article;
    }
}
