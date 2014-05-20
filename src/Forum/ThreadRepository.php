<?php namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Member;

interface ThreadRepository
{
    public function getBySlug($slug);
    public function getByTagsAndStatusPaginated($tagString, $status, $perPage = 20);
    public function getRecentByMember(Member $member, $count);
    public function save(Model $thread);
}
