<?php

namespace Lio\Replies;

use Lio\DateTime\Timestamps;
use Lio\Users\Authored;

interface Reply extends Authored, Timestamps
{
    public function id(): int;
    public function body(): string;
    public function replyAble(): ReplyAble;
}
