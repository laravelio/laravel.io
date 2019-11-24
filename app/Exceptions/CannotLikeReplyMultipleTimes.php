<?php

namespace App\Exceptions;

use Exception;

class CannotLikeReplyMultipleTimes extends Exception
{
    protected $message = 'A reply cannot be liked multiple times.';
}
