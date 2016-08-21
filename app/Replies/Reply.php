<?php

namespace App\Replies;

use App\DateTime\Timestamps;
use App\Users\Authored;

interface Reply extends Authored, Timestamps
{
    public function id(): int;
    public function body(): string;
    public function replyAble(): ReplyAble;
}
