<?php

namespace App\Spam;

use App\Users\User;

class PhoneNumberSpamDetector implements SpamDetector
{
    public function detectsSpam($value, User $user = null): bool
    {
        return (bool) preg_match('/(\+|~)(?:\d{1,2})?[\s-+]*?(?:\d{10,})/', $value);
    }
}
