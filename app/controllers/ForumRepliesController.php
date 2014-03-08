<?php

use Lio\Core\CommandBus;
use Lio\Forum\Replies\ReplyQueryStringGenerator;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Threads\Commands;
use Lio\Forum\Threads\ThreadRepository;

class ForumRepliesController extends \BaseController
{
    private $replies;
    private $queryStringGenerator;
    private $bus;

    private $repliesPerPage = 20;

    function __construct(ReplyRepository $replies, CommandBus $bus, ReplyQueryStringGenerator $queryStringGenerator)
    {
        $this->replies = $replies;
        $this->bus = $bus;
        $this->queryStringGenerator = $queryStringGenerator;
    }

    public function getReplyRedirect($threadSlug, $replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $queryString = $this->queryStringGenerator->generate($reply, $this->repliesPerPage);

        return $this->redirectTo(action('ForumThreadsController@getShowThread', [$threadSlug]) . $queryString);
    }

    public function postCreate($threadSlug)
    {
        
    }

    public function getEdit($replyId)
    {

    }

    public function postEdit($replyId)
    {

    }

    public function getDelete($replyId)
    {

    }

    public function postDelete($replyId)
    {

    }
} 
