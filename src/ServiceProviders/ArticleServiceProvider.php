<?php  namespace Lio\ServiceProviders; 

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Lio\Articles\ArticleRepository', 'Lio\Articles\EloquentArticleRepository');
    }

    public function provides()
    {
        return ['Lio\Article\ArticleRepository'];
    }
}
