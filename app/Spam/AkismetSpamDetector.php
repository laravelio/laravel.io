<?php

namespace App\Spam;

use App\User;
use TijsVerkoyen\Akismet\Akismet;

class AkismetSpamDetector implements SpamDetector
{
    /**
     * @var \TijsVerkoyen\Akismet\Akismet
     */
    private $akismet;

    public function __construct(Akismet $akismet)
    {
        $this->akismet = $akismet;
    }

    public function detectsSpam($value, User $user = null): bool
    {
        $name = $user ? $user->name() : null;
        $email = $user ? $user->emailAddress() : null;

        if (! $this->akismet->verifyKey()) {
            return false;
        }

        return $this->akismet->isSpam($value, $name, $email);
    }
}
