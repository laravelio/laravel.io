<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Event, App;

class AccountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Lio\Accounts\MemberRepository', 'Lio\Accounts\EloquentMemberRepository');
    }
}
