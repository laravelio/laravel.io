<?php

namespace App\Users;

use App\DateTime\Timestamps;

interface User extends Timestamps
{
    public function id(): int;
    public function name(): string;
    public function emailAddress(): string;
    public function username(): string;
    public function githubUsername(): string;
    public function gratavarUrl($size = 100): string;

    /**
     * @return \App\Replies\Reply[]
     */
    public function replies();
}
