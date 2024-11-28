<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Notifications\PostArticleToBluesky;
use App\Notifications\PostArticleToTwitter;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

final class PostArticleToSocialMedia extends Command
{
    protected $signature = 'lio:post-article-to-social-media';

    protected $description = 'Posts the latest unshared article to social media';

    public function handle(AnonymousNotifiable $notifiable): void
    {
        if ($article = Article::nextForSharing()) {
            $notifiable->notify(new PostArticleToBluesky($article));
            $notifiable->notify(new PostArticleToTwitter($article));

            $article->markAsShared();
        }
    }
}
