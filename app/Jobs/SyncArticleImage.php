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
        $response = Http::retry(3, 100, throw: false)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID')
            ->get("https://api.unsplash.com/photos/{$article->hero_image_id}");

        if ($response->failed()) {
            $article->hero_image_id = null;
            $article->save();

            return null;
        }

        $response = $response->json();

        // Trigger as Unsplash download...
        Http::retry(3, 100, throw: false)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID')
            ->get($response['links']['download_location']);

        return [
            'image_url' => $response['urls']['raw'],
            'author_name' => $response['user']['name'],
            'author_url' => $response['user']['links']['html'],
        ];
    }
}
