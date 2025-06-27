<?php

namespace App\Console\Commands;

use App\Jobs\SyncArticleImage;
use App\Models\Article;
use Illuminate\Console\Command;

final class SyncArticleImages extends Command
{
    protected $signature = 'lio:sync-article-images';

    protected $description = 'Updates the Unsplash image for all unsynced articles';

    public function handle(): void
    {
        if (! config('services.unsplash.access_key')) {
            $this->error('Unsplash access key must be configured');

            return;
        }

        Article::unsyncedImages()->chunk(100, function ($articles) {
            $articles->each(function ($article) {
                SyncArticleImage::dispatch($article);
            });
        });
    }
}
