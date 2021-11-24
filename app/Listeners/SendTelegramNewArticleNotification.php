<?php

namespace App\Listeners;

use App\Events\ArticleWasCreated;
use App\Notifications\ArticleSubmitted;
use Illuminate\Notifications\AnonymousNotifiable;

final class SendTelegramNewArticleNotification
{
    public function __construct(
        private AnonymousNotifiable $notifiable
    ) {
    }

    public function handle(ArticleWasCreated $event): void
    {
        $this->notifiable->notify(new ArticleSubmitted($event->article));
    }
}
