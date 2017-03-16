<?php

namespace App;

use App\Forum\Thread;
use Auth;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Hash;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootHelpers();
        $this->bootPasscheckValidationRule();
        $this->bootEloquentMorphs();
    }

    private function bootHelpers()
    {
        require __DIR__ . '/helpers.php';
    }

    private function bootPasscheckValidationRule()
    {
        Validator::extend('passcheck', function ($attribute, $value, $parameters)
        {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });
    }

    private function bootEloquentMorphs()
    {
        Relation::morphMap([
            Thread::TABLE => Thread::class,
        ]);
    }
}
