<?php

namespace App\Spam;

use App\User;

interface SpamDetector
{
    public function detectsSpam($value, User $user = null): bool;
}
