<?php namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Member;

interface ThreadRepository
{
    public function getBySlug($slug);
    public function getPageByTagsAndStatus($tagString, $status, $page, $threadsPerPage);
    public function getRecentByMember(Member $member, $count);
    public function save(Model $thread);
}
