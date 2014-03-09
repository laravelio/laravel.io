<?php

use Lio\CommandBus\CommandBusInterface;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Threads\Commands;
use Lio\Forum\Threads\Thread;
use Lio\Forum\Threads\ThreadRepository;
use Lio\Forum\Threads\ThreadSearch;
use Lio\Tags\TagRepository;

class ForumThreadsController extends \BaseController
{
    private $threads;
    private $tags;
    private $bus;
    private $search;

    private $numberOfThreadsOnIndex = 50;
    private $repliesPerPage = 20;

    function __construct(ThreadRepository $threads, ReplyRepository $replies, ThreadSearch $search, TagRepository $tags, CommandBusInterface $bus)
    {
        $this->threads = $threads;
        $this->replies = $replies;
        $this->tags = $tags;
        $this->bus = $bus;
        $this->search = $search;
    }

    public function getIndex($status = '')
    {
        $threads = $this->threads->getByTagsAndStatusPaginated(Input::get('tags'), $status, $this->numberOfThreadsOnIndex);
        $queryString = Input::get('tags') ? 'tags=' . Input::get('tags') : '';

        $this->title = "Forum";
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
        $versions = Thread::$laravelVersions;

        $this->title = "Create Forum Thread";
        $this->view('forum.threads.create', compact('tags', 'versions'));
    }

    public function postCreate()
    {
        $command = new Commands\CreateThreadCommand(
            Input::get('subject'),
            Input::get('body'),
            Auth::user(),
            Input::get('is_question'),
            Input::get('laravel_version'),
            Input::get('tags', [])
        );
        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShow', $thread->slug);
    }

    public function getUpdate($threadId)
    {
        $tags = $this->tags->getAllForForum();
        $versions = Thread::$laravelVersions;
        $thread = $this->threads->requireById($threadId);

        $this->title = "Update Forum Thread";
        $this->view('forum.threads.update', compact('thread', 'tags', 'versions'));
    }

    public function postUpdate($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        $command = new Commands\UpdateThreadCommand(
            $thread,
            Input::get('subject'),
            Input::get('body'),
            Auth::user(),
            Input::get('is_question'),
            Input::get('laravel_version'),
            Input::get('tags', [])
        );

        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShow', $thread->slug);
    }

    public function getMarkThreadSolved($threadId, $solvedByReplyId)
    {
        $thread = $this->threads->requireById($threadId);
        $reply = $this->replies->requireById($solvedByReplyId);
        $command = new Commands\MarkThreadSolvedCommand($thread, $reply, Auth::user());
        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShow', $thread->slug);
    }

    public function getMarkThreadUnsolved($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $command = new Commands\MarkThreadUnsolvedCommand($thread, Auth::user());
        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShow', $thread->slug);
    }

    public function getDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        $this->title = "Delete Forum Thread";
        $this->view('forum.threads.delete', compact('thread'));
    }

    public function postDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $command = new Commands\DeleteThreadCommand($thread);
        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getIndex');
    }

    public function getSearch()
    {
        $query = Input::get('query');
        $results = $this->search->getPaginatedResults($query, $this->numberOfThreadsOnIndex);

        $this->title = "Forum Search";
        $this->view('forum.search', compact('query', 'results'));
    }
} 
