<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\PostArticleToTwitter;
use Illuminate\Notifications\Events\NotificationSent;

final class PersistTweetId
{
    public function handle(NotificationSent $event): void
    {
        if (! $event->notification instanceof PostArticleToTwitter) {
            return;
        }

        $event->notification
            ->getArticle()
            ->update([
                'tweet_id' => $event->response->id,
            ]);
    }
}
