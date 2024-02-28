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
}
