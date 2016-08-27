<?php

namespace App\Validation;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('not_contain_url', DoesNotContainUrlRule::class.'@validate');
    }
}
