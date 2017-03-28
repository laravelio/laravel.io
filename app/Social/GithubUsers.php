<?php

namespace App\Social;

interface GithubUsers
{
    public function findByUsername(string $username): GithubUser;
}
