<?php

namespace App\Exceptions;

use App\Models\Reply;
use Exception;

final class CouldNotMarkReplyAsSolution extends Exception
{
    public static function replyAbleIsNotAThread(Reply $reply): self
    {
        return new self("The reply with an id of [{$reply->id()} is not linked to a thread.]");
    }
}
