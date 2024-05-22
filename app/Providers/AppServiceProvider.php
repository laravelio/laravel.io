<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\SlowQueryLogged;
use App\Observers\UserObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/user';

    public function boot(): void
    {
        $this->bootEloquentMorphs();
        $this->bootMacros();
        $this->bootHorizon();
        $this->bootSlowQueryLogging();

        $this->bootEvent();
        $this->bootRoute();
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
        // Horizon::routeSlackNotificationsTo(config('lio.horizon.webhook'));

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
                    RequestFacade::url(),
                ),
            );
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function bootEvent(): void
    {
        User::observe(UserObserver::class);
    }

    public function bootRoute(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(6);
        });

        require base_path('routes/bindings.php');

    }
}
