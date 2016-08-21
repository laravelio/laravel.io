<?php

namespace App\Spam;

use App\Users\User;

interface SpamDetector
{
    public function detectsSpam($value, User $user = null): bool;
}
