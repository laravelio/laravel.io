<?php

use Lio\Articles\ArticleRepository;
use Lio\CommandBus\CommandBusInterface;
use Lio\Tags\TagRepository;
use Lio\Articles\Commands;

class ArticlesController extends \BaseController
{
    private $articles;
    private $tags;
    private $bus;

    function __construct(ArticleRepository $articles, TagRepository $tags, CommandBusInterface $bus)
    {
        $this->articles = $articles;
        $this->tags = $tags;
        $this->bus = $bus;
    }

    public function getIndex()
    {
        $tags = $this->tags->getAllTagsBySlug($this->request->input('tags'));
        $articles = $this->articles->getAllPublishedByTagsPaginated($tags);

        $this->title = 'Articles';
        $this->view('articles.index', compact('articles'));
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
