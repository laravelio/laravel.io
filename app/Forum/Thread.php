<?php

namespace Lio\Forum;

use Lio\DateTime\Timestamps;
use Lio\Users\User;

interface Thread extends Timestamps
{
    const TYPE = 'threads';

    public function id(): int;
    public function subject(): string;
    public function body(): string;
    public function slug(): string;
    public function author(): User;
    public function isAuthoredBy(User $user): bool;

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
