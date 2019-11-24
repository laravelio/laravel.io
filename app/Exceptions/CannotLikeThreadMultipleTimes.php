<?php

namespace App\Exceptions;

use Exception;

class CannotLikeThreadMultipleTimes extends Exception
{
    protected $message = 'A thread cannot be liked multiple times.';
}
