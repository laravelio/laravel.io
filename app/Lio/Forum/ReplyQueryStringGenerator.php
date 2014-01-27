<?php namespace Lio\Forum;

class ReplyQueryStringGenerator
{
    public function generate(Reply $reply, $perPage = 20)
    {
        $precedingReplyCount = $reply->precedingReplyCount();
        // $numberthreadsBefore = Thread::where('parent_id', '=', $thread->parent_id)->where('created_at', '<', $thread->created_at)->count();
        $pageNumber = $this->getPageNumber($precedingReplyCount, $perPage);
        // $page = round($numberthreadsBefore / $this->threadsPerPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        // return Redirect::to(action('ForumThreadsController@getShowThread', [$thread]) . "?page={$page}#thread-{$threadId}");

        return "?page={$pageNumber}#thread-{$reply->thread_id}";
    }

    private function getPageNumber($count, $perPage)
    {
        return round($count / $perPage, 0, PHP_ROUND_HALF_DOWN) + 1;
    }
}