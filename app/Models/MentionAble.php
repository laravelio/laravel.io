<?php

namespace App\Models;

interface MentionAble
{
    public function body(): string;

    public function excerpt(): string;

    public function author(): User;

    public function mentionedOn(): ReplyAble;
}
