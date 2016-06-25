<?php

namespace Lio\Views;

use Blade;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        collect($filesystem->files(resource_path('macros')))->each(function ($path) {
            require_once $path;
        });
    }

    public function register()
    {
    }
}
