<?php

use Lio\Forum\UseCases\ListThreadsRequest;
use Lio\Forum\UseCases\PostThreadRequest;
use Lio\Forum\UseCases\ViewThreadRequest;

class ForumController extends BaseController
{
    private $threadsPerPage = 50;
    private $repliesPerPage = 20;

    public function getListThreads($status = '')
    {
        $request = new ListThreadsRequest(
            Input::get('tags'),
            $status,
            Input::get('page'),
            $this->threadsPerPage
        );
        $response = $this->bus->execute($request);

        $this->title = 'Forum';
        $this->render('forum.threads.index', [
            'threads' => $response->threads,
            'tags' => Input::get('tags'),
            'queryString' => Input::get('tags') ? 'tags=' . Input::get('tags') : '',
        ]);
    }

    public function getViewThread($threadSlug)
    {
        $request = new ViewThreadRequest($threadSlug, 0, $this->repliesPerPage);
        $response = $this->bus->execute($request);

        $this->title = $response->thread->title;
        $this->render('forum.threads.show', [
            'thread' => $response->thread,
            'replies' => $response->replies
        ]);
    }

    public function getPostThread()
    {
        $tags = $this->tags->getAllForForum();
        $versions = Laravel::$versions;
        $this->title = 'Create Forum Thread';
        $this->render('forum.threads.create', compact('tags', 'versions'));
    }

    public function postPostThread()
    {
        $request = new PostThreadRequest(
            Auth::user(),
            Input::get('subject'),
            Input::get('body'),
            Input::get('is_question'),
            Input::get('laravel_version'),
            Input::get('tags', [])
        );
        $response = $this->bus->execute($request);

        return Redirect::action('ForumController@getShow', [$response->thread->slug]);
    }

    public function getUpdate($threadId)
    {
        $tags = $this->tags->getAllForForum();
        $versions = Laravel::$versions;
        $thread = $this->threads->requireById($threadId);
        $this->title = 'Update Forum Thread';
        $this->render('forum.threads.update', compact('thread', 'tags', 'versions'));
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
        return Redirect::action('ForumController@getShow', [$thread->slug]);
    }

    public function getMarkThreadSolved($threadId, $solvedByReplyId)
    {
        $thread = $this->threads->requireById($threadId);
        $reply = $this->replies->requireById($solvedByReplyId);
        $command = new Commands\MarkThreadSolvedCommand($thread, $reply, Auth::user());
        $thread = $this->bus->execute($command);
        return Redirect::action('ForumController@getShow', [$thread->slug]);
    }

    public function getMarkThreadUnsolved($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $command = new Commands\MarkThreadUnsolvedCommand($thread, Auth::user());
        $thread = $this->bus->execute($command);
        return Redirect::action('ForumController@getShow', [$thread->slug]);
    }

    public function getDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $this->title = 'Delete Forum Thread';
        $this->render('forum.threads.delete', compact('thread'));
    }

    public function postDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);
        $command = new Commands\DeleteThreadCommand($thread, Auth::user());
        $thread = $this->bus->execute($command);
        return Redirect::action('ForumController@getListThreads');
    }

    public function getSearch()
    {
        $query = Input::get('query');
        $results = $this->search->getPaginatedResults($query, $this->numberOfThreadsOnIndex);
        $this->title = 'Forum Search';
        $this->render('forum.search', compact('query', 'results'));
    }
} 
