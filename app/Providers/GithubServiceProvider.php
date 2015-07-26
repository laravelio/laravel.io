<?php
namespace Lio\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Lio\Accounts\UserRepository;
use Lio\Github\GistEmbedFormatter;
use Lio\Github\GithubAuthenticator;

class GithubServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->registerGistEmbedFormatter();
        $this->registerGithubAuthenticator();
    }

    private function registerGistEmbedFormatter()
    {
        $this->app->singleton(GistEmbedFormatter::class, function () {
            return new GistEmbedFormatter;
        });
    }

    private function registerGithubAuthenticator()
    {
        $this->app->singleton(GithubAuthenticator::class, function ($app) {
            return new GithubAuthenticator($app[Factory::class]->driver('github'), $app[UserRepository::class]);
        });
    }

    public function provides()
    {
        return [GistEmbedFormatter::class, GithubAuthenticator::class];
    }
}
