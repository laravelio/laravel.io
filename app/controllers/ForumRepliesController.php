<?php

use Lio\CommandBus\CommandBusInterface;
use Lio\Forum\Replies\ReplyQueryStringGenerator;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Replies\Commands;
use Lio\Forum\Threads\ThreadRepository;

class ForumRepliesController extends \BaseController
{
    private $replies;
    private $threads;
    private $queryStringGenerator;
    private $bus;

    private $repliesPerPage = 20;

    function __construct(ReplyRepository $replies, ThreadRepository $threads, CommandBusInterface $bus, ReplyQueryStringGenerator $queryStringGenerator)
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

        return $this->redirectTo(action('ForumThreadsController@getShow', [$threadSlug]) . $queryString);
    }

    public function postCreate($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);

        $command = new Commands\CreateReplyCommand($thread, Input::get('body'), Auth::user());
        $reply = $this->bus->execute($command);
        return $this->redirectAction('ForumRepliesController@getReplyRedirect', [$thread->slug, $reply->id]);
    }

    public function getUpdate($replyId)
    {
        $reply = $this->replies->requireById($replyId);

        $this->title = "Update Forum Reply";
        $this->view('forum.replies.update', compact('reply'));
    }

    public function postUpdate($replyId)
    {
        $reply = $this->replies->requireById($replyId);

        $command = new Commands\UpdateReplyCommand($reply, Input::get('body'));
        $reply = $this->bus->execute($command);
        return $this->redirectAction('ForumRepliesController@getReplyRedirect', [$reply->thread->slug, $reply->id]);
    }

    public function getDelete($replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $this->view('forum.replies.delete', compact('reply'));
    }

    public function postDelete($replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $thread = $reply->thread;
        $command = new Commands\DeleteReplyCommand($reply, Auth::user());
        $reply = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShow', [$thread->slug]);
    }
} 
