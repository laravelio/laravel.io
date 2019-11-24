<?php

namespace App\Providers;

use App\Models\Reply;
use App\Models\Thread;
use Horizon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootEloquentMorphs();
        $this->bootMacros();
        $this->bootHorizon();
    }

    private function bootEloquentMorphs()
    {
        Relation::morphMap([
            Thread::TABLE => Thread::class,
            Reply::TABLE => Reply::class,
        ]);
    }

    public function bootMacros()
    {
        require base_path('resources/macros/blade.php');
    }

    public function bootHorizon()
    {
        Horizon::routeMailNotificationsTo($horizonEmail = config('lio.horizon.email'));
        Horizon::routeSlackNotificationsTo(config('lio.horizon.webhook'));

        Horizon::auth(function ($request) use ($horizonEmail) {
            return auth()->check() && auth()->user()->emailAddress() === $horizonEmail;
        });
    }
}
