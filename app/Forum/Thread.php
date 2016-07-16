<?php

namespace Lio\Forum;

use Lio\DateTime\Timestamps;
use Lio\Tags\Taggable;
use Lio\Users\Authored;

interface Thread extends Authored, Taggable, Timestamps
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
