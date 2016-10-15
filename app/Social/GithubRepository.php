<?php

namespace App\Social;

interface GithubRepository
{
    public function findByUsername(string $username): GithubUser;
}
