<?php

namespace App\Jobs;

use App\Models\Article;
use Carbon\Carbon;

final class ApproveArticle
{
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): Article
    {
        $this->article->approved_at = Carbon::now();
        $this->article->save();

        return $this->article;
    }
}
