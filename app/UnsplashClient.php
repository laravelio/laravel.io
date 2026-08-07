<?php

namespace App;

use App\Exceptions\UnsplashRequestFailed;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class UnsplashClient
{
    private const string API_URL = 'https://api.unsplash.com';

    private PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::retry(3, 100, throw: false)
            ->timeout(10)
            ->connectTimeout(3)
            ->withToken(config('services.unsplash.access_key'), 'Client-ID');
    }

    /**
     * @throws \App\Exceptions\UnsplashRequestFailed
     */
    public function searchPhotos(string $query, int $page = 1): array
    {
        $response = $this->http->get(self::API_URL.'/search/photos', [
            'query' => $query,
            'page' => $page,
            'per_page' => 12,
            'orientation' => 'landscape',
            'content_filter' => 'high',
        ]);

        if ($response->failed()) {
            throw new UnsplashRequestFailed;
        }

        return $response->json();
    }

    /**
     * @throws \App\Exceptions\UnsplashRequestFailed
     */
    public function findPhoto(string $id): array
    {
        $response = $this->http->get(self::API_URL."/photos/{$id}");

        if ($response->failed()) {
            throw new UnsplashRequestFailed;
        }

        return $response->json();
    }

    /**
     * @throws \App\Exceptions\UnsplashRequestFailed
     */
    public function downloadPhoto(string $location): void
    {
        $response = $this->http->get($location);

        if ($response->failed()) {
            throw new UnsplashRequestFailed;
        }
    }
}
