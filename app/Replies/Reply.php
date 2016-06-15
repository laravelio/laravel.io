<?php

namespace Lio\Replies;

use Lio\DateTime\Timestamps;
use Lio\Users\User;

interface Reply extends Timestamps
{
    public function id(): int;
    public function body(): string;
    public function author(): User;
    public function replyAble(): ReplyAble;
}
