<?php

use \Lio\Forum\Threads\ThreadForm;

class ForumThreadsController extends BaseController implements
    \Lio\Forum\Threads\ThreadCreatorListener,
    \Lio\Forum\Threads\ThreadUpdaterListener,
    \Lio\Forum\Threads\ThreadDeleterListener
{
    protected $threads;
    protected $tags;
    protected $sections;
    protected $currentSection;

    protected $threadsPerPage = 20;
    protected $repliesPerPage = 20;

    public function __construct(
        \Lio\Forum\Threads\ThreadRepository $threads,
        \Lio\Tags\TagRepository $tags,
        \Lio\Forum\SectionCountManager $sections
    ) {
        $this->threads = $threads;
        $this->tags     = $tags;
        $this->sections = $sections;

        $this->prepareViewData();
    }

    // show thread list
    public function getIndex()
    {
        // update user timestamp
        View::share('last_visited_timestamp', App::make('Lio\Forum\SectionCountManager')->updatedAndGetLastVisited(Input::get('tags')));

        // query tags and retrieve the appropriate threads
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $threads = $this->threads->getByTagsPaginated($tags, $this->threadsPerPage);

        // add the tag string to each pagination link
        $threads->appends(['tags' => Input::get('tags')]);
        $this->createSections(Input::get('tags'));

        $this->view('forum.threads.index', compact('threads', 'tags'));
    }

    // show a thread
    public function getShowThread($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);
        $replies = $this->threads->getThreadRepliesPaginated($thread, $this->repliesPerPage);

        $this->createSections($thread->getTags());
        $this->view('forum.threads.show', compact('thread', 'replies'));
    }

    // create a thread
    public function getCreateThread()
    {
        $tags = $this->tags->getAllForForum();
        $versions = $this->threads->getNew()->getLaravelVersions();
        $this->createSections(Input::get('tags'));

        $this->view('forum.threads.create', compact('tags', 'versions'));
    }

    public function postCreateThread()
    {
        return App::make('Lio\Forum\Threads\ThreadCreator')->create($this, [
            'subject'         => Input::get('subject'),
            'body'            => Input::get('body'),
            'author'          => Auth::user(),
            'laravel_version' => Input::get('laravel_version'),
            'tags'            => $this->tags->getTagsByIds(Input::get('tags')),
        ], new ThreadForm);
    }

    public function threadCreationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function threadCreated($thread)
    {
        return $this->redirectAction('ForumThreadsController@getShowThread', [$thread->slug]);
    }

    // edit a thread
    public function getEditThread($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isOwnedBy(Auth::user())) {
            return Redirect::to('/');
        }

        $tags = $this->tags->getAllForForum();
        $versions = $thread->getLaravelVersions();

        $this->createSections(Input::get('tags'));
        $this->view('forum.threads.edit', compact('thread', 'tags', 'versions'));
    }

    public function postEditThread($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isOwnedBy(Auth::user())) {
            return Redirect::to('/');
        }

        return App::make('Lio\Forum\Threads\ThreadUpdater')->update($this, $thread, [
            'subject'         => Input::get('subject'),
            'body'            => Input::get('body'),
            'laravel_version' => Input::get('laravel_version'),
            'tags'            => $this->tags->getTagsByIds(Input::get('tags')),
        ], new ThreadForm);
    }

    // observer methods
    public function threadUpdateError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function threadUpdated($thread)
    {
        return $this->redirectAction('ForumThreadsController@getShowThread', [$thread->slug]);
    }

    // thread deletion
    public function getDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isOwnedBy(Auth::user())) {
            return Redirect::to('/');
        }

        $this->createSections(Input::get('tags'));
        $this->view('forum.threads.delete', compact('thread'));
    }

    public function postDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isOwnedBy(Auth::user())) {
            return Redirect::to('/');
        }

        return App::make('Lio\Forum\Threads\ThreadDeleter')->delete($this, $thread);
    }

    // observer methods
    public function threadDeleted()
    {
        return Redirect::action('ForumThreadsController@getIndex');
    }

    // forum thread search
    public function getSearch()
    {
        View::share('last_visited_timestamp', App::make('Lio\Forum\SectionCountManager')->updatedAndGetLastVisited(Input::get('tags')));

        $query = Input::get('query');
        $results = App::make('Lio\Forum\Threads\ThreadSearch')->searchPaginated($query, $this->threadsPerPage);
        $results->appends(array('query' => $query));

        $this->createSections(Input::get('tags'));
        $this->view('forum.search', compact('query', 'results'));
    }

    // ------------------------- //
    private function prepareViewData()
    {
        $sectionCounts = $this->sections->getCounts(Session::get('forum_last_visited'));
        View::share(compact('sectionCounts'));
    }

    private function createSections($currentSection = null)
    {
        $forumSections = App::make('Lio\Forum\SectionSidebarCreator')->createSidebar($currentSection);
        View::share(compact('forumSections'));
    }
}