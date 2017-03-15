<?php

namespace Lio\Forum\Replies;

class ReplyQueryStringGenerator
{
    public function generate($reply, $perPage = 20)
    {
        $precedingReplyCount = $reply->getPrecedingReplyCount();
        $pageNumber = $this->getPageNumber($precedingReplyCount, $perPage);

        return "?page={$pageNumber}#reply-{$reply->id}";
    }

    private function getPageNumber($count, $perPage)
    {
        return floor($count / $perPage) + 1;
    }
}
