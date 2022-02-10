<?php

namespace App\Providers;

use App\Events\ArticleWasApproved;
use App\Events\ArticleWasSubmittedForApproval;
use App\Events\ReplyWasCreated;
use App\Events\ThreadWasCreated;
use App\Listeners\MarkLastActivity;
use App\Listeners\NotifyUsersMentionedInReply;
use App\Listeners\NotifyUsersMentionedInThread;
use App\Listeners\SendArticleApprovedNotification;
use App\Listeners\SendNewArticleNotification;
use App\Listeners\SendNewReplyNotification;
use App\Listeners\StoreTweetIdentifier;
use App\Listeners\SubscribeUsersMentionedInReply;
use App\Listeners\SubscribeUsersMentionedInThread;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationSent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ThreadWasCreated::class => [
            SubscribeUsersMentionedInThread::class,
            NotifyUsersMentionedInThread::class,
        ],
        ReplyWasCreated::class => [
            MarkLastActivity::class,
            SendNewReplyNotification::class,
            SubscribeUsersMentionedInReply::class,
            NotifyUsersMentionedInReply::class,
        ],
        ArticleWasSubmittedForApproval::class => [
            SendNewArticleNotification::class,
        ],
        ArticleWasApproved::class => [
            SendArticleApprovedNotification::class,
        ],
        NotificationSent::class => [
            StoreTweetIdentifier::class,
        ],
    ];
}
