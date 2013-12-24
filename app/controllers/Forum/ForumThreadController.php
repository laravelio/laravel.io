<?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

use Lio\Tags\TagRepository;

use Lio\Forum\ForumThreadForm;
use Lio\Forum\ForumThreadCreatorObserver;
use Lio\Forum\ForumThreadUpdaterObserver;
use Lio\Forum\ForumSectionCountManager;

class ForumThreadController extends BaseController implements ForumThreadCreatorObserver, ForumThreadUpdaterObserver
{
    protected $categories;
    protected $comments;
    protected $sections;

    protected $threadsPerPage = 20;
    protected $commentsPerPage = 20;

    public function __construct(CommentRepository $comments, TagRepository $tags, ForumSectionCountManager $sections)
    {
        $this->comments = $comments;
        $this->tags = $tags;
        $this->sections = $sections;

        $forumSections = Config::get('forum.sections');
        $sectionCounts = $this->sections->getCounts($forumSections, Session::get('forum_last_visited'));

        View::share(compact('forumSections', 'sectionCounts'));
    }

    public function index()
    {
        // update user timestamp
        View::share('last_visited_timestamp', App::make('Lio\Forum\ForumSectionCountManager')->updatedAndGetLastVisited(Input::get('tags')));
        // query tags and retrieve the appropriate threads
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $threads = $this->comments->getForumThreadsByTagsPaginated($tags, $this->threadsPerPage);
        // add the tag string to each pagination link
        $threads->appends(['tags' => Input::get('tags')]);
        // display the index
        $this->view('forum.index', compact('threads'));
    }

    public function create()
    {
        $tags = $this->tags->getAllForForum();
        $versions = Comment::$laravelVersions;
        $this->view('forum.createthread', compact('tags', 'versions'));
    }

    public function store()
    {
        $tags = $this->tags->getTagsByIds(Input::get('tags'));
        return App::make('Lio\Forum\ForumThreadCreator')->create($this, [
            'title'           => Input::get('title'),
            'body'            => Input::get('body'),
            'author_id'       => Auth::user()->id,
            'type'            => Comment::TYPE_FORUM,
            'laravel_version' => Input::get('laravel_version'),
            'tags'            => $tags,
        ], new ForumThreadForm);
    }

    public function show()
    {
        $thread = App::make('slugModel');
        $comments = $this->comments->getThreadCommentsPaginated($thread, $this->commentsPerPage);
        $this->view('forum.thread', compact('thread', 'comments'));
    }

    public function edit($threadId)
    {
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        $tags = $this->tags->getAllForForum();
        $versions = Comment::$laravelVersions;

        $this->view('forum.editthread', compact('thread', 'tags', 'versions'));
    }

    public function update($threadId)
    {
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        $tags = $this->tags->getTagsByIds(Input::get('tags'));

        return App::make('Lio\Forum\ForumThreadUpdater')->update($thread, $this, [
            'title'           => Input::get('title'),
            'body'            => Input::get('body'),
            'laravel_version' => Input::get('laravel_version'),
            'tags'            => $tags,
        ], new ForumThreadForm);
    }

    // observer methods
    public function forumThreadValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function forumThreadCreated($thread)
    {
        $this->sections->cacheSections(Config::get('forum.sections'));
        return $this->redirectAction('ForumThreadController@show', [$thread->slug()->first()->slug]);
    }

    public function forumThreadUpdated($thread)
    {
        return $this->redirectAction('ForumThreadController@show', [$thread->slug->slug]);
    }
}