<?php

namespace App\Spam;

use App\User;

class DummySpamDetector implements SpamDetector
{
    /**
     * @var bool
     */
    private $hasSpam;

    private function __construct(bool $hasSpam)
    {
        $this->hasSpam = $hasSpam;
    }

    public static function withSpam(): self
    {
        return new static(true);
    }

    public static function withoutSpam(): self
    {
        return new static(false);
    }

    public function detectsSpam($value, User $user = null): bool
    {
        return $this->hasSpam;
    }
}
