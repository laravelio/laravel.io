<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Contracts\Spam;

final class SpamWasReported
{
    use SerializesModels;

    public function __construct(public Spam $spam)
    {
    }
}
