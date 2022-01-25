<?php

namespace App\Jobs;

use App\Models\Article;
use App\Notifications\ArticleDeletedNotification;

final class DeleteArticle
{
    public function __construct(
        private Article $article,
        private $message = null
    ) {
    }

    public function handle()
    {
        if ($this->message) {
            $this->article->author()->notify(new ArticleDeletedNotification($this->article, $this->message));
        }
        $this->article->delete();
    }
}
