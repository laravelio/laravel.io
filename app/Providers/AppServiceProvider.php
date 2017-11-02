<?php

namespace App\Providers;

use App\Models\Thread;
use Psr\Log\LoggerInterface;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootEloquentMorphs();
        $this->bootMacros();
    }

    private function bootEloquentMorphs()
    {
        Relation::morphMap([
            Thread::TABLE => Thread::class,
        ]);
    }

    public function bootMacros()
    {
        require base_path('resources/macros/blade.php');
    }

    public function register()
    {
        $this->app->alias('bugsnag.multi', Log::class);
        $this->app->alias('bugsnag.multi', LoggerInterface::class);
    }
}
