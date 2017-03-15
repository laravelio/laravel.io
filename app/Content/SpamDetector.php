<?php

namespace Lio\Content;

use Lio\Accounts\User;

interface SpamDetector
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function detectsSpam($value, User $user = null);
}
