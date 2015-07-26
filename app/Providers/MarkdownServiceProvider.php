<?php
namespace Lio\Providers;

use Illuminate\Support\ServiceProvider;
use Event, App;

class MarkdownServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('Lio\Markdown\HtmlMarkdownConvertor', function($app) {
            return new \Lio\Markdown\HtmlMarkdownConvertor;
        });
    }

    public function provides()
    {
        return ['Lio\Markdown\HtmlMarkdownConvertor'];
    }
}
