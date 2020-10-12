<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ArticleWasApproved;
use App\Notifications\ArticleApprovedNotification;

final class SendArticleApprovedNotification
{
    public function handle(ArticleWasApproved $event): void
    {
        $event->article->author()->notify(new ArticleApprovedNotification($event->article));
    }
}
