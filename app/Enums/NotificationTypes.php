<?php

namespace App\Enums;

use App\Notifications\NewReplyNotification;
use App\Notifications\MentionNotification;

enum NotificationTypes: string
{
    case MENTION = 'mention';
    case REPLY = 'reply';

    public function getClass(): string
    {
        return match($this)
        {
            self::MENTION => MentionNotification::class,
            self::REPLY => NewReplyNotification::class,
        };
    }

    public function label(): string
    {
        return match($this)
        {
            self::MENTION => "Mention",
            self::REPLY => "Reply",
        };
    }

    public static function getTypes(): array
    {
        return [
          self::MENTION->value => self::MENTION->label(),
          self::REPLY->value => self::REPLY->label(),
        ];
    }
}