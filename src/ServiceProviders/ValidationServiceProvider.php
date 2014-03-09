<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Event, App;

class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {}

    public function boot()
    {
        \Validator::extend('max_tags', function ($attribute, $tagIds, $params) {
            $maxCount = $params[0];

            $tagRepo = App::make('Lio\Tags\TagRepository');
            $tags = $tagRepo->getTagsByIds($tagIds);

            if (is_null($tags) || $tags->count() > $maxCount) {
                return false;
            }

            return true;
        });
    }
}
