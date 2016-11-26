<?php

namespace App\Replies;

use App\Users\User;

interface ReplyData
{
    public function replyAble(): ReplyAble;
    public function author(): User;
    public function body(): string;
    public function ip();
}
