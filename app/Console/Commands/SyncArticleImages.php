<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

final class SyncArticleImages extends Command
{
    protected $signature = 'lio:sync-article-images';

    protected $description = 'Updates the Unsplash image for all articles';

    protected $accessKey;

    public function __construct()
    {
        parent::__construct();

        $this->accessKey = config('services.unsplash.access_key');
    }

    public function handle(): void
    {
        if (! $this->accessKey) {
            $this->error('Unsplash access key must be configured');

            return;
        }

        Article::published()->chunk(100, function ($articles) {
            $articles->each(function ($article) {
                if (! $article->hero_image) {
                    // Update Unsplash image URL
                }
            });
        });
    }
}
