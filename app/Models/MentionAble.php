<?php

namespace App\Models;

use Illuminate\Support\Collection;

interface MentionAble
{
    public function body(): string;

    public function excerpt(): string;

    public function author(): User;

    public function mentionedIn(): ReplyAble;

    public function mentionedUsers(): Collection;
}
