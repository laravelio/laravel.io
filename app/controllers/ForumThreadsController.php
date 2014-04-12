<?php

use Lio\Laravel\Laravel;
use Lio\Tags\TagRepository;
use Illuminate\Http\Request;
use Lio\CommandBus\CommandBus;
use Lio\Forum\Threads\Commands;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;
use Lio\Forum\Threads\ThreadSearch;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Threads\ThreadRepository;

class ForumThreadsController extends BaseController
{
    private $bus;
    private $tags;
    private $search;
    private $threads;
    private $request;

    private $numberOfThreadsOnIndex = 50;
    private $repliesPerPage = 20;
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var Illuminate\Routing\Redirector
     */
    private $redirector;

    function __construct(ThreadRepository $threads, ReplyRepository $replies, ThreadSearch $search, TagRepository $tags, CommandBus $bus, Request $request, AuthManager $auth, Redirector $redirector)
    {
        $this->bus = $bus;
        $this->auth = $auth;
        $this->tags = $tags;
        $this->search = $search;
        $this->threads = $threads;
        $this->replies = $replies;
        $this->request = $request;
        $this->redirector = $redirector;
    }

    public function getIndex($status = '')
    {
        $threads = $this->threads->getByTagsAndStatusPaginated($this->request->get('tags'), $status, $this->numberOfThreadsOnIndex);
        $queryString = $this->request->get('tags') ? 'tags=' . $this->request->get('tags') : '';

        $this->title = 'Forum';
        $this->view('forum.threads.index', compact('threads', 'tags', 'queryString'));
    }

    public function getShow($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);
        $replies = $this->threads->getThreadRepliesPaginated($thread, $this->repliesPerPage);

        $this->title = $thread->title;
        $this->view('forum.threads.show', compact('thread', 'replies'));
    }

    public function getCreate()
    {
        $tags = $this->tags->getAllForForum();
        $versions = Laravel::$versions;
        $this->title = 'Create Forum Thread';
        $this->view('forum.threads.create', compact('tags', 'versions'));
    }

    public function postCreate()
    {
        $command = new Commands\CreateThreadCommand(
            $this->request->get('subject'),
            $this->request->get('body'),
            $this->auth->user(),
            $this->request->get('is_question'),
            $this->request->get('laravel_version'),
            $this->request->get('tags', [])
        );
        $thread = $this->bus->execute($command);
        return $this->redirector->action('ForumThreadsController@getShow', [$thread->slug]);
    }

    public function getUpdate($threadId)
    {
        $tags = $this->tags->getAllForForum();
        $versions = Laravel::$versions;
        $thread = $this->threads->requireById($threadId);
        $this->title = 'Update Forum Thread';
        $this->view('forum.threads.update', compact('thread', 'tags', 'versions'));
    }

    public function postUpdate($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        $command = new Commands\UpdateThreadCommand(
            $thread,
            $this->request->get('subject'),
            $this->request->get('body'),
            $this->auth->user(),
            $this->request->get('is_question'),
            $this->request->get('laravel_version'),
            $this->request->get('tags', [])
        );

        $thread = $this->bus->execute($command);
        return $this->redirector->action('ForumThreadsController@getShow', [$thread->slug]);
    }

    public function getMarkThreadSolved($threadId, $solvedByReplyId)
    {
        $thread = $this->threads->requireById($threadId);
        $reply = $this->replies->requireById($solvedByReplyId);
        $command = new Commands\MarkThreadSolvedCommand($thread, $reply, $this->auth->user());
        $thread = $this->bus->execute($command);
        return $this->redirector->action('ForumThreadsController@getShow', [$thread->slug]);
    }

    public function getMarkThreadUnsolved($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $command = new Commands\MarkThreadUnsolvedCommand($thread, $this->auth->user());
        $thread = $this->bus->execute($command);
        return $this->redirector->action('ForumThreadsController@getShow', [$thread->slug]);
    }

    public function getDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $this->title = 'Delete Forum Thread';
        $this->view('forum.threads.delete', compact('thread'));
    }

    public function postDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $command = new Commands\DeleteThreadCommand($thread, $this->auth->user());
        $thread = $this->bus->execute($command);
        return $this->redirector->action('ForumThreadsController@getIndex');
    }

    public function getSearch()
    {
        $query = $this->request->get('query');
        $results = $this->search->getPaginatedResults($query, $this->numberOfThreadsOnIndex);
        $this->title = 'Forum Search';
        $this->view('forum.search', compact('query', 'results'));
    }
} 
