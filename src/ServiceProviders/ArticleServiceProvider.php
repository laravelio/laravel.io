<?php  namespace Lio\ServiceProviders; 

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Lio\Article\ArticleRepository', 'Lio\Article\EloquentArticleRepository');
    }

    public function provides()
    {
        return ['Lio\Article\ArticleRepository'];
    }
}
