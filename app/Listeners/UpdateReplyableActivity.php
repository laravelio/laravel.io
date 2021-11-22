<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;

final class UpdateReplyableActivity
{
    public function handle(ReplyWasCreated $event): void
    {
        $event->reply->replyAble()->touchActivity();
    }
}
