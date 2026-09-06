<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

final class SyncArticleImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Article $article)
    {
        //
    }

    public function handle(): void
    {
        $imageData = $this->fetchUnsplashImageDataFromId($this->article);

        if (! is_null($imageData)) {
            $this->article->hero_image_url = $imageData['image_url'];
            $this->article->hero_image_author_name = $imageData['author_name'];
            $this->article->hero_image_author_url = $imageData['author_url'];
            $this->article->save();
        }
    }

    protected function fetchUnsplashImageDataFromId(Article $article): ?array
    {
        if (! $article->hero_image_id) {
            return null;
        }

        $response = Http::retry(3, 100, throw: false)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID')
            ->get("https://api.unsplash.com/photos/{$article->hero_image_id}");

        if ($response->failed()) {
            $article->hero_image_id = null;
            $article->save();

            return null;
        }

        $downloadLocation = $response->json('links.download_location');
        $imageUrl = $response->json('urls.raw');
        $authorName = $response->json('user.name');
        $authorUrl = $response->json('user.links.html');

        foreach ([$downloadLocation, $imageUrl, $authorName, $authorUrl] as $value) {
            if (! is_string($value) || trim($value) === '') {
                return null;
            }
        }

        // Trigger as Unsplash download...
        Http::retry(3, 100, throw: false)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID')
            ->get($downloadLocation);

        return [
            'image_url' => $imageUrl,
            'author_name' => $authorName,
            'author_url' => $authorUrl,
        ];
    }
}
