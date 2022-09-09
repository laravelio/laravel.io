<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\SlowQueryLogged;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootEloquentMorphs();
        $this->bootMacros();
        $this->bootHorizon();
        $this->bootSlowQueryLogging();
    }

    private function bootEloquentMorphs()
    {
        Relation::morphMap([
            Article::TABLE => Article::class,
            Thread::TABLE => Thread::class,
            Reply::TABLE => Reply::class,
            User::TABLE => User::class,
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

        Horizon::auth(function ($request) {
            return auth()->check() && auth()->user()->isAdmin();
        });
    }

    private function bootSlowQueryLogging()
    {
        DB::whenQueryingForLongerThan(300000, function (Connection $connection, QueryExecuted $event) {
            Notification::send(
                new AnonymousNotifiable,
                new SlowQueryLogged(
                    $event->sql,
                    $event->time,
                    Request::url(),
                ),
            );
        });
    }
}
