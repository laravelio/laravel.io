<?php

use Lio\CommandBus\CommandBus;
use Lio\Forum\Replies\Commands;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;
use Lio\Forum\EloquentReplyRepository;
use Lio\Forum\EloquentThreadRepository;
use Symfony\Component\HttpFoundation\Request;
use Lio\Forum\Replies\ReplyQueryStringGenerator;

class ForumRepliesController extends \BaseController
{
    private $replies;
    private $threads;
    private $queryString;
    private $bus;
    private $redirector;
    private $repliesPerPage = 20;
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    private $request;

    function __construct(EloquentReplyRepository $replies, EloquentThreadRepository $threads, CommandBus $bus, ReplyQueryStringGenerator $queryString, Redirector $redirector, AuthManager $auth, Request $request)
    {
        $this->bus = $bus;
        $this->auth = $auth;
        $this->replies = $replies;
        $this->threads = $threads;
        $this->request = $request;
        $this->redirector = $redirector;
        $this->queryString = $queryString;
    }

    public function getReplyRedirect($threadSlug, $replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $queryString = $this->queryString->generate($reply, $this->repliesPerPage);
        return $this->redirector->to(action('ForumController@getShow', [$threadSlug]) . $queryString);
    }

    public function postCreate($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);
        $command = new Commands\CreateReplyCommand($thread, $this->input->get('body'), $this->auth->user());
        $reply = $this->bus->execute($command);
        return $this->redirector->action('ForumRepliesController@getReplyRedirect', [$thread->slug, $reply->id]);
    }

    public function getUpdate($replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $this->title = 'Update Forum Reply';
        $this->render('forum.replies.update', compact('reply'));
    }

    public function postUpdate($replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $command = new Commands\UpdateReplyCommand($reply, $this->input->get('body'), $this->auth->user());
        $reply = $this->bus->execute($command);
        return $this->redirector->action('ForumRepliesController@getReplyRedirect', [$reply->thread->slug, $reply->id]);
    }

    public function getDelete($replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $this->render('forum.replies.delete', compact('reply'));
    }

    public function postDelete($replyId)
    {
        $reply = $this->replies->requireById($replyId);
        $thread = $reply->thread;
        $command = new Commands\DeleteReplyCommand($reply, $this->auth->user());
        $reply = $this->bus->execute($command);
        return $this->redirector->action('ForumController@getShow', [$thread->slug]);
    }
} 
