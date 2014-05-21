<?php namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Member;
use Lio\Forum\Threads\Thread;

interface ReplyRepository
{
    public function getRecentByMember(Member $member, $count);
    public function getRepliesForThread(Thread $thread, $page, $repliesPerPage);
    public function save(Model $thread);
}
