<?php

use Lio\Core\CommandBus;
use Lio\Forum\Replies\ReplyQueryStringGenerator;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Threads\Commands;
use Lio\Forum\Threads\ThreadRepository;

class ForumRepliesController extends \BaseController
{
    private $replies;
    private $threads;
    private $queryStringGenerator;
    private $bus;

    private $repliesPerPage = 20;

    function __construct(ReplyRepository $replies, ThreadRepository $threads, CommandBus $bus, ReplyQueryStringGenerator $queryStringGenerator)
    {
        $this->replies = $replies;
        $this->bus = $bus;
        $this->queryStringGenerator = $queryStringGenerator;
        $this->threads = $threads;
    }

    public function getReplyRedirect($threadSlug, $replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $queryString = $this->queryStringGenerator->generate($reply, $this->repliesPerPage);

        return $this->redirectTo(action('ForumThreadsController@getShowThread', [$threadSlug]) . $queryString);
    }

    public function postCreate($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);

        return App::make('Lio\Forum\Replies\ReplyCreator')->create($this, [
            'body'   => Input::get('body'),
            'author' => Auth::user(),
        ], $thread->id, new ReplyForm);

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
