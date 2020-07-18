<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;
use App\Notifications\PostArticleToTwitter as PostArticleToTwitterNotification;

final class PostArticleToTwitter extends Command
{
    protected $signature = 'post-article-to-twitter';

    protected $description = 'Posts the latest unshared article to Twitter';

    private $notifiable;

    public function __construct(AnonymousNotifiable $notifiable)
    {
        parent::__construct();
        $this->notifiable = $notifiable;
    }

    public function handle()
    {
        if (! $article = Article::nextForSharing()) {
            return;
        }

        $this->notifiable->notify(new PostArticleToTwitterNotification($article));

        $article->markAsShared();
    }
}
