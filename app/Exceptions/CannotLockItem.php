<?php

namespace App\Exceptions;

use Exception;

final class CannotLockItem extends Exception
{
    public static function alreadyLocked(string $item): self
    {
        return new self("The {$item} cannot be locked multiple times.");
    }
}
