<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Queue\SerializesModels;

class ArticleWasSubmittedForApproval
{
    use SerializesModels;

    public function __construct(
        public Article $article
    ) {
    }
}
