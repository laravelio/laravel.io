<?php

namespace App\Providers;

use App\Events\ArticleWasApproved;
use App\Events\ArticleWasSubmittedForApproval;
use App\Events\ReplyWasCreated;
use App\Events\ThreadWasCreated;
use App\Listeners\MarkLastActivity;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\SendArticleApprovedNotification;
use App\Listeners\SendNewArticleNotification;
use App\Listeners\SendNewReplyNotification;
use App\Listeners\StoreTweetIdentifier;
use App\Listeners\SubscribeMentionedUsersToThread;
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
            SubscribeMentionedUsersToThread::class,
            NotifyMentionedUsers::class,
        ],
        ReplyWasCreated::class => [
            MarkLastActivity::class,
            SendNewReplyNotification::class,
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
