<?php

namespace App;

use App\Forum\Thread;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
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
        foreach ($this->app[Filesystem::class]->files(resource_path('macros')) as $path) {
            require $path;
        }
    }
}
