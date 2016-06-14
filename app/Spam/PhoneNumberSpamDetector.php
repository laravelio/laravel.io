<?php
namespace Lio\Spam;

use Lio\Users\User;

class PhoneNumberSpamDetector implements SpamDetector
{
    /** @inheritdoc */
    public function detectsSpam($value, User $user = null)
    {
        return (bool) preg_match('/(\+|~)(?:\d{1,2})?[\s-+]*?(?:\d{10,})/', $value);
    }
}
