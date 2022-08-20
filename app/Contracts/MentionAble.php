<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface MentionAble
{
    public function body(): string;

    public function excerpt(): string;

    public function author(): User;

    public function mentionedIn(): ReplyAble;

    public function mentionedUsers(): Collection;
}
