<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Queue\SerializesModels;

final class ArticleWasApproved
{
    use SerializesModels;

    public function __construct(
        public Article $article
    ) {
    }
}
