<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\Github\Requests\AccessTokenRequest;
use Lio\Github\GistEmbedFormatter;
use Lio\Github\GithubAuthenticator;
use Lio\Github\Requests\UserEmailRequest;
use Lio\Github\Requests\UserRequest;

class GithubServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('Lio\Github\GistEmbedFormatter', function($app) {
            return new GistEmbedFormatter;
        });
        $this->app->singleton('Lio\Github\GithubAuthenticator', function($app) {
            return new GithubAuthenticator(
                $app['config']->get('github'),
                $app['Lio\Accounts\MemberRepository'],
                new AccessTokenRequest,
                new UserRequest,
                new UserEmailRequest
            );
        });
    }

    public function provides()
    {
        return ['Lio\Github\GistEmbedFormatter', 'Lio\Github\GithubAuthenticator'];
    }
}
