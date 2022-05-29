<?php

namespace App\Concerns;

use App\Models\ReplyAble;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait HasMentions
{
    public function mentionedIn(): ReplyAble
    {
        if ($this instanceof ReplyAble) {
            return $this;
        }

        return $this->replyAble();
    }

    public function getMentionedUsers(): Collection
    {
        preg_match_all('/@([a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w))/', $this->body(), $matches);

        return User::whereIn('username', $matches[1])->get();
    }

    public function repositionMention(?string $body): string
    {
        $body = Str::of($body);

        if (!$body->startsWith('<') || !$body->contains('@')) {
            return $body->toString();
        }

        $mentionRegex = '@[a-z\d]*(?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)';

        $mentions = $body
            ->matchAll('/'.$mentionRegex. '/')
            ->toArray();

        return implode(' ', $mentions) . ' ' . preg_replace('/\s*'.$mentionRegex. '\s*/', '', $body->toString());
    }
}
