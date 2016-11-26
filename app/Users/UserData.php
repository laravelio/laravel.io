<?php

namespace App\Users;

interface UserData
{
    public function name(): string;
    public function emailAddress(): string;
    public function username(): string;
    public function password(): string;
    public function ip();
    public function githubId(): string;
    public function githubUsername(): string;
}
