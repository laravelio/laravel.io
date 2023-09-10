<?php

namespace App\Providers;

use App\Events\ArticleWasApproved;
use App\Events\ArticleWasSubmittedForApproval;
use App\Events\EmailAddressWasChanged;
use App\Events\ReplyWasCreated;
use App\Events\SpamWasReported;
use App\Events\ThreadWasCreated;
use App\Listeners\MarkLastActivity;
use App\Listeners\NotifyUsersMentionedInReply;
use App\Listeners\NotifyUsersMentionedInThread;
use App\Listeners\RenewEmailVerificationNotification;
use App\Listeners\SendArticleApprovedNotification;
use App\Listeners\SendNewArticleNotification;
use App\Listeners\SendNewReplyNotification;
use App\Listeners\SendNewSpamNotification;
use App\Listeners\SubscribeUsersMentionedInReply;
use App\Listeners\SubscribeUsersMentionedInThread;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ArticleWasSubmittedForApproval::class => [
            SendNewArticleNotification::class,
        ],
        ArticleWasApproved::class => [
            SendArticleApprovedNotification::class,
        ],
        EmailAddressWasChanged::class => [
            RenewEmailVerificationNotification::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ReplyWasCreated::class => [
            MarkLastActivity::class,
            SendNewReplyNotification::class,
            SubscribeUsersMentionedInReply::class,
            NotifyUsersMentionedInReply::class,
        ],
        ThreadWasCreated::class => [
            SubscribeUsersMentionedInThread::class,
            NotifyUsersMentionedInThread::class,
        ],
        SpamWasReported::class => [
            SendNewSpamNotification::class,
        ],
    ];

    public function boot(): void
    {
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
