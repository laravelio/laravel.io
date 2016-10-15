<?php

namespace App\Social;

use GuzzleHttp\Client as Guzzle;

class GuzzleGithubRepository implements GithubRepository
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function findByUsername(string $username): GithubUser
    {
        $endpoint = "https://api.github.com/users/$username";

        return new GithubUser(json_decode($this->guzzle->get($endpoint)->getBody()->getContents(), true));
    }
}
