<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;

final class MarkLastActivity
{
    public function handle(ReplyWasCreated $event): void
    {
        $replyAble = $event->reply->replyAble();
        $replyAble->last_activity_at = now();
        $replyAble->save();
    }
}
