<?php

namespace App\Jobs;

use App\Exceptions\UnsplashRequestFailed;
use App\Models\Article;
use App\UnsplashClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class SyncArticleImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Article $article)
    {
        //
    }

    public function handle(UnsplashClient $unsplash): void
    {
        if (! $this->article->hero_image_id) {
            return;
        }

        try {
            $photo = $unsplash->findPhoto($this->article->hero_image_id);
            $unsplash->downloadPhoto($photo['links']['download_location']);
        } catch (UnsplashRequestFailed) {
            $this->article->hero_image_id = null;
            $this->article->save();

            return;
        }

        $this->article->hero_image_url = $photo['urls']['raw'];
        $this->article->hero_image_author_name = $photo['user']['name'];
        $this->article->hero_image_author_url = $photo['user']['links']['html'];
        $this->article->save();
    }
}
