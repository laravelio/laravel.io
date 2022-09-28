<?php

namespace App\Events;

use App\Contracts\Spam;
use Illuminate\Queue\SerializesModels;

final class SpamWasReported
{
    use SerializesModels;

    public function __construct(public Spam $spam)
    {
    }
}
