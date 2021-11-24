<?php

namespace App\Providers;

use App\Events\ReplyWasCreated;
use App\Events\ArticleWasApproved;
use App\Listeners\MarkLastActivity;
use App\Listeners\StoreTweetIdentifier;
use App\Listeners\SendNewReplyNotification;
use App\Listeners\SendArticleApprovedNotification;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        ArticleWasApproved::class => [
            SendArticleApprovedNotification::class,
        ],
        NotificationSent::class => [
            StoreTweetIdentifier::class,
        ],
    ];
}
