<?php

namespace Lio\Users;

use Lio\DateTime\Timestamps;

interface User extends Timestamps
{
    public function id(): int;
    public function name(): string;
    public function emailAddress(): string;
    public function username(): string;
    public function githubUsername(): string;
    public function gratavarUrl($size = 100): string;

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
