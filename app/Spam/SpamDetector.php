<?php

namespace Lio\Spam;

use Lio\Users\User;

interface SpamDetector
{
    public function detectsSpam($value, User $user = null): bool;
}
