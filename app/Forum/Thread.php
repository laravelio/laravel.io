<?php

namespace App\Forum;

use App\DateTime\Timestamps;
use App\Forum\Topics\Topic;
use App\Replies\Reply;
use App\Tags\Taggable;
use App\Users\Authored;

interface Thread extends Authored, Taggable, Timestamps
{
    const TYPE = 'threads';

    public function id(): int;
    public function subject(): string;
    public function body(): string;
    public function slug(): string;
    public function topic(): Topic;

    /**
     * @return \App\Replies\Reply|null
     */
    public function solutionReply();
    public function isSolutionReply(Reply $reply): bool;

    /**
     * @return \App\Replies\Reply[]
     */
    public function replies();
}
