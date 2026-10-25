<?php

namespace App\Listeners;

use App\Events\ArticleWasSubmittedForApproval;
use App\Notifications\ArticleSubmitted;
use App\Services\ReviewArticle;
use Illuminate\Notifications\AnonymousNotifiable;

final class SendNewArticleNotification
{
    public function __construct(private AnonymousNotifiable $notifiable, private ReviewArticle $reviewer) {}

    public function handle(ArticleWasSubmittedForApproval $event): void
    {
        if ($event->article->isNotAwaitingApproval() || ! $this->reviewer->allowsManualReview($event->article)) {
            return;
        }

        $this->notifiable->notify(new ArticleSubmitted($event->article));
    }
}
