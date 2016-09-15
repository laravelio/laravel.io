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
    public function isConfirmed(): bool;
    public function isUnconfirmed(): bool;
    public function confirmationCode(): string;
    public function matchesConfirmationCode(string $code): bool;

    /**
     * @return \App\Replies\Reply[]
     */
    public function replies();
}
