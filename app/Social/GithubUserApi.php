<?php

namespace App\Social;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Exception;

class GithubUserApi
{
    private string $api = 'https://api.github.com/user';

    /**
     * @param int|string $id GitHub user id
     * @return object|null
     */
    public function find(int|string $id): ?object
    {
        $apiToken = config('services.github.api_token');

        $response = Http::withToken($apiToken)
            ->retry(3, 100,  function (Exception $exception, PendingRequest $request) {
                return $exception instanceof ConnectionException;
            })
            ->get("{$this->api}/{$id}");

        if ($response->failed()) {
            return null;
        }

        return $response->object();
    }
}
