<?php namespace Lio\Forum\Replies;

class ReplyQueryStringGenerator
{
    public function generate(Reply $reply, $perPage = 20)
    {
        $precedingReplyCount = $reply->getPrecedingReplyCount();

        // $numberthreadsBefore = Thread::where('parent_id', '=', $thread->parent_id)->where('created_at', '<', $thread->created_at)->count();
        $pageNumber = $this->getPageNumber($precedingReplyCount, $perPage);
        // $page = round($numberthreadsBefore / $this->threadsPerPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        // return Redirect::to(action('ForumController@getShow', [$thread]) . "?page={$page}#thread-{$threadId}");

        return "?page={$pageNumber}#reply-{$reply->id}";
    }

    private function getPageNumber($count, $perPage)
    {
        return floor($count / $perPage) + 1;
    }
}
