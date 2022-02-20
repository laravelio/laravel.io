<?php

namespace App\Listeners;

use App\Events\ArticleWasSubmittedForApproval;
use App\Notifications\ArticleSubmitted;
use Illuminate\Notifications\AnonymousNotifiable;

final class SendNewArticleNotification
{
    public function __construct(
        private AnonymousNotifiable $notifiable
    ) {
    }

    public function handle(ArticleWasSubmittedForApproval $event): void
    {
        if (! empty(config('services.telegram-bot-api.token')) && ! empty(config('services.telegram-bot-api.channel'))) {
            $this->notifiable->notify(new ArticleSubmitted($event->article));
        }
    }
}
