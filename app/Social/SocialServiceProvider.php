<?php

namespace App\Social;

use Illuminate\Support\ServiceProvider;

class SocialServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GithubRepository::class, GuzzleGithubRepository::class);
    }
}
