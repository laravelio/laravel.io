<?php

namespace App\Social;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GithubUserApi
{
    public function find(int|string $id): ?GitHubUser
    {
        $response = Http::retry(3, 100, fn ($exception) => $exception instanceof ConnectionException)
            ->get("https://api.github.com/user/{$id}");

        return $response->failed() ? null : new GitHubUser($response->json());
    }

    public function hasIdenticon(int|string $id): bool
    {
        $detectionSize = 40;
        $response = Http::retry(3, 300, fn ($exception) => $exception instanceof ConnectionException)
            ->get("https://avatars.githubusercontent.com/u/{$id}?v=4&s={$detectionSize}");

        if ($response->failed()) {
            return true;
        }

        $info = getimagesizefromstring($response->body());

        if (!$info) {
            return true;
        }

        [$width, $height] = $info;

        return !($width === 420 && $height === 420);
    }
}
