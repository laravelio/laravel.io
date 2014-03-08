<?php

use Lio\Core\CommandBus;
use Lio\Forum\Threads\Commands\CreateThreadCommand;
use Lio\Forum\Threads\Commands\UpdateThreadCommand;
use Lio\Forum\Threads\Thread;
use Lio\Forum\Threads\ThreadRepository;
use Lio\Tags\TagRepository;

class ForumThreadsController extends \BaseController
{
    private $threads;
    private $tags;
    private $bus;

    private $numberOfThreadsOnIndex = 50;
    private $repliesPerPage = 20;

    function __construct(ThreadRepository $threads, TagRepository $tags, CommandBus $bus)
    {
        $this->threads = $threads;
        $this->tags = $tags;
        $this->bus = $bus;
    }

    public function getIndex($status = '')
    {
        $threads = $this->threads->getByTagsAndStatusPaginated(Input::get('tags'), $status, $this->numberOfThreadsOnIndex);
        $queryString = Input::get('tags') ? 'tags=' . Input::get('tags') : '';

        $this->title = "Forum";
        $this->view('forum.threads.index', compact('threads', 'tags', 'queryString'));
    }

    public function getShowThread($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);
        $replies = $this->threads->getThreadRepliesPaginated($thread, $this->repliesPerPage);

        $this->title = $thread->title;
        $this->view('forum.threads.show', compact('thread', 'replies'));
    }

    public function getCreateThread()
    {
        $tags = $this->tags->getAllForForum();
        $versions = Thread::$laravelVersions;

        $this->title = "Create Forum Thread";
        $this->view('forum.threads.create', compact('tags', 'versions'));
    }

    public function postCreateThread()
    {
        $command = new CreateThreadCommand(
            Input::get('subject'),
            Input::get('body'),
            Auth::user(),
            Input::get('is_question'),
            Input::get('laravel_version'),
            Input::get('tags', [])
        );
        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShowThread', $thread->slug);
    }

    public function getUpdateThread($threadId)
    {
        $tags = $this->tags->getAllForForum();
        $versions = Thread::$laravelVersions;
        $thread = $this->threads->requireById($threadId);

        $this->title = "Update Forum Thread";
        $this->view('forum.threads.update', compact('thread', 'tags', 'versions'));
    }

    public function postUpdateThread($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        $command = new UpdateThreadCommand(
            $thread,
            Input::get('subject'),
            Input::get('body'),
            Auth::user(),
            Input::get('is_question'),
            Input::get('laravel_version'),
            Input::get('tags', [])
        );

        $thread = $this->bus->execute($command);
        return $this->redirectAction('ForumThreadsController@getShowThread', $thread->slug);
    }

    public function getMarkQuestionSolved($threadId, $solvedByReplyId)
    {

    }

    public function getMarkQuestionUnsolved($threadId)
    {

    }

    public function getDelete($threadId)
    {

    }

    public function postDelete($threadId)
    {

    }

    public function getSearch()
    {

    }
} 
