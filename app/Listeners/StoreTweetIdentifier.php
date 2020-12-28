<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\PostArticleToTwitter;
use Illuminate\Notifications\Events\NotificationSent;

final class StoreTweetIdentifier
{
    public function handle(NotificationSent $event): void
    {
        if ($event->notification instanceof PostArticleToTwitter) {
            $event->notification->article()->update([
                'tweet_id' => $event->response->id,
            ]);
        }
    }
}
