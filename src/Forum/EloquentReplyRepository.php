<?php namespace Lio\Forum;

use Lio\Accounts\Member;
use Lio\Core\EloquentRepository;
use Lio\Forum\Replies\Reply;
use Lio\Forum\Threads\Thread;

class EloquentReplyRepository extends EloquentRepository implements ReplyRepository
{
    public function __construct(Reply $model)
    {
        $this->model = $model;
    }

    public function getRecentByMember(Member $member, $count = 5)
    {
        return $this->model->with('thread')->where('author_id', '=', $member->id)->orderBy('created_at', 'desc')->take($count)->get();
    }

    public function getRepliesForThread(Thread $thread, $page, $repliesPerPage)
    {
        return $this->model->with('author')->skip($page * $repliesPerPage)->take($repliesPerPage)->orderBy('created_at', 'asc')->get();
    }
}
