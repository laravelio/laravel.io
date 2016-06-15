<?php

namespace Lio\Forum;

use Lio\DateTime\Timestamps;

interface Thread extends Timestamps
{
    const TYPE = 'threads';

    public function id(): int;
    public function subject(): string;
    public function body(): string;
    public function slug(): string;

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
