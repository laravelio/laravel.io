<?php

namespace Lio\Auth;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Lio\Forum\EloquentThread;
use Lio\Forum\ThreadPolicy;
use Lio\Replies\EloquentReply;
use Lio\Replies\ReplyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        EloquentReply::class => ReplyPolicy::class,
        EloquentThread::class => ThreadPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
