<?php namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Member;

interface ThreadRepository
{
    public function getRecentByMember(Member $member, $count);
    public function save(Model $thread);
}
