<?php
namespace Lio\Spam;

use Lio\Users\User;

interface SpamDetector
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function detectsSpam($value, User $user = null);
}
