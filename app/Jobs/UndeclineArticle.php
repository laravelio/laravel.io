<?php

namespace App\Jobs;

use App\Models\Article;
use function now;

class UndeclineArticle
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
        $this->article->declined_at = null;
        $this->article->save();

        return $this->article;
    }
}
