<?php

namespace App\Listeners;

use App\Events\ArticleWasCreated;
use App\Notifications\ArticleSubmitted;
use Illuminate\Notifications\AnonymousNotifiable;

final class SendTelegramNewArticleNotification
{
    public function handle(ArticleWasCreated $event): void
    {
        (new AnonymousNotifiable())->notify(new ArticleSubmitted($event->article));
    }
}
