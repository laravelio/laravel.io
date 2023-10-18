<?php

namespace App\Enums;

use App\Notifications\MentionNotification;
use App\Notifications\NewReplyNotification;

enum NotificationType: string
{
    case MENTION = 'mention';
    case REPLY = 'reply';

    public function getClass(): string
    {
        return match ($this) {
            self::MENTION => MentionNotification::class,
            self::REPLY => NewReplyNotification::class,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::MENTION => 'Mentions',
            self::REPLY => 'Replies',
        };
    }

    public static function getTypes(): array
    {
        return [
            self::MENTION->value => self::MENTION,
            self::REPLY->value => self::REPLY,
        ];
    }
}
