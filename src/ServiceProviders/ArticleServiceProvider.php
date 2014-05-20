<?php  namespace Lio\ServiceProviders; 

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Lio\Articles\Repositories\ArticleRepository', 'Lio\Articles\Repositories\EloquentArticleRepository');
        $this->app->bind('Lio\Articles\Repositories\CommentRepository', 'Lio\Articles\Repositories\EloquentCommentRepository');
    }

    public function provides()
    {
        return [
            'Lio\Articles\Repositories\ArticleRepository',
            'Lio\Articles\Repositories\CommentRepository'
        ];
    }
}
