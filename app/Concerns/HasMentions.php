<?php

namespace App\Concerns;

use App\Contracts\ReplyAble;
use App\Models\User;
use Illuminate\Support\Collection;

trait HasMentions
{
    public function mentionedIn(): ReplyAble
    {
        if ($this instanceof ReplyAble) {
            return $this;
        }

        return $this->replyAble();
    }

    public function mentionedUsers(): Collection
    {
        preg_match_all('/@([a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w))/', $this->body(), $matches);

        return User::whereIn('username', $matches[1])->get();
    }
}
