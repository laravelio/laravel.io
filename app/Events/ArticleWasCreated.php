<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Queue\SerializesModels;

class ArticleWasCreated
{
    use SerializesModels;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
