<?php

namespace App\Providers;

use App\User;
use App\Models\Reply;
use App\Models\Thread;
use App\Policies\UserPolicy;
use App\Policies\ReplyPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Reply::class => ReplyPolicy::class,
        Thread::class => ThreadPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
