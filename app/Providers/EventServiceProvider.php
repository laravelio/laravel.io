<?php

namespace App\Providers;

use App\Events\ArticleWasApproved;
use App\Events\ArticleWasCreated;
use App\Events\ReplyWasCreated;
use App\Listeners\MarkLastActivity;
use App\Listeners\SendArticleApprovedNotification;
use App\Listeners\SendNewReplyNotification;
use App\Listeners\SendNewArticleNotification;
use App\Listeners\StoreTweetIdentifier;
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
        ReplyWasCreated::class => [
            MarkLastActivity::class,
            SendNewReplyNotification::class,
        ],
        ArticleWasCreated::class => [
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
