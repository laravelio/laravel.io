<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
                $imageData = $this->fetchUnsplashImageDataFromId($article->hero_image_id);

                if (! is_null($imageData)) {
                    $article->hero_image_url = $imageData['image_url'];
                    $article->hero_image_author_name = $imageData['author_name'];
                    $article->hero_image_author_url = $imageData['author_url'];
                    $article->save();
                }
            });
        });
    }

    protected function fetchUnsplashImageDataFromId(string $imageId): ?array
    {
        $response = Http::retry(3, 100, throw: false)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID')
            ->get("https://api.unsplash.com/photos/{$imageId}");

        if ($response->failed()) {
            logger()->error('Failed to get raw image url from unsplash for', [
                'imageId' => $imageId,
                'response' => $response->json(),
            ]);

            return null;
        }

        $response = $response->json();

        // Trigger as download...
        Http::retry(3, 100, throw: false)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID')
            ->get($response['links']['download_location']);

        return [
            'image_url' => $response['urls']['raw'],
            'author_name' => $response['user']['name'],
            'author_url' => $response['user']['links']['html']
        ];
    }
}
