<?php

namespace Lio\Forum;

use Lio\DateTime\Timestamps;
use Lio\Forum\Topics\Topic;
use Lio\Tags\Taggable;
use Lio\Users\Authored;

interface Thread extends Authored, Taggable, Timestamps
{
    const TYPE = 'threads';

    public function id(): int;
    public function subject(): string;
    public function body(): string;
    public function slug(): string;
    public function topic(): Topic;

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
