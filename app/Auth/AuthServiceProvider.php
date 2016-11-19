<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Forum\Thread;
use App\Forum\ThreadPolicy;
use App\Replies\Reply;
use App\Replies\ReplyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Reply::class => ReplyPolicy::class,
        Thread::class => ThreadPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
