<?php

use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Threads\ThreadCreator;
use Lio\Forum\Threads\ThreadCreatorListener;
use Lio\Forum\Threads\ThreadDeleterListener;
use \Lio\Forum\Threads\ThreadForm;
use Lio\Forum\Threads\ThreadRepository;
use Lio\Forum\Threads\ThreadUpdaterListener;
use Lio\Tags\TagRepository;

class ForumThreadsController extends BaseController implements
    ThreadCreatorListener,
    ThreadUpdaterListener,
    ThreadDeleterListener
{
    protected $threads;
    protected $tags;
    protected $currentSection;
    protected $threadCreator;
    private $replies;

    protected $threadsPerPage = 50;
    protected $repliesPerPage = 20;

    public function __construct(
        ThreadRepository $threads,
        ReplyRepository $replies,
        TagRepository $tags,
        ThreadCreator $threadCreator
    )
    {
        $this->threads = $threads;
        $this->tags = $tags;
        $this->threadCreator = $threadCreator;
        $this->replies = $replies;
    }

    // show thread list - clean this method
    public function getIndex($status = '')
    {
        // query tags and retrieve the appropriate threads
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $threads = $this->threads->getByTagsAndStatusPaginated($tags, $status, $this->threadsPerPage);

        // add the tag string to each pagination link
        $tagAppends = ['tags' => Input::get('tags')];
        $queryString = ! empty($tagAppends['tags']) ? '?tags=' . implode(',', (array) $tagAppends['tags']) : '';
        $threads->appends($tagAppends);
        $this->createSections(Input::get('tags'));

        $this->title = 'Forum';
        $this->view('forum.threads.index', compact('threads', 'tags', 'queryString'));
    }

    // show a thread
    public function getShowThread($threadSlug)
    {
        $thread = $this->threads->getBySlug($threadSlug);

        if (! $thread) {
            return $this->redirectAction('ForumThreadsController@getIndex');
        }

        $replies = $this->threads->getThreadRepliesPaginated($thread, $this->repliesPerPage);

        $this->createSections($thread->getTags());

        $this->title = ($thread->isSolved() ? '[SOLVED] ' : '') . $thread->subject;
        $this->view('forum.threads.show', compact('thread', 'replies'));
    }

    // create a thread
    public function getCreateThread()
    {
        $this->createSections(Input::get('tags'));

        if (App::environment('production') && Auth::user()->hasCreatedAThreadRecently()) {
            return $this->view('forum.threads.throttle');
        }

        $tags = $this->tags->getAllForForum();
        $versions = $this->threads->getNew()->getLaravelVersions();

        $this->title = "Create Forum Thread";
        $this->view('forum.threads.create', compact('tags', 'versions'));
    }

    public function postCreateThread()
    {
        if (App::environment('production') && Auth::user()->hasCreatedAThreadRecently()) {
            return Redirect::action('ForumThreadsController@getCreateThread');
        }

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make(Input::only('g-recaptcha-response'), [
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        if ($validator->fails()) {
            return Redirect::action('ForumThreadsController@getCreateThread')
                ->exceptInput('g-recaptcha-response')
                ->withErrors($validator->errors());
        }

        return $this->threadCreator->create($this, [
            'subject' => Input::get('subject'),
            'body' => Input::get('body'),
            'author' => Auth::user(),
            'laravel_version' => Input::get('laravel_version'),
            'is_question' => Input::get('is_question'),
            'tags' => $this->tags->getTagsByIds(Input::get('tags')),
            'ip' => Request::ip(),
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

        if ( ! $thread->isManageableBy(Auth::user())) {
            return Redirect::to('/');
        }

        $tags = $this->tags->getAllForForum();
        $versions = $thread->getLaravelVersions();

        $this->createSections(Input::get('tags'));

        $this->title = "Edit Forum Thread";
        $this->view('forum.threads.edit', compact('thread', 'tags', 'versions'));
    }

    public function postEditThread($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isManageableBy(Auth::user())) {
            return Redirect::to('/');
        }

        return App::make('Lio\Forum\Threads\ThreadUpdater')->update($this, $thread, [
            'subject' => Input::get('subject'),
            'body' => Input::get('body'),
            'is_question' => Input::get('is_question', 0),
            'laravel_version' => Input::get('laravel_version'),
            'tags' => $this->tags->getTagsByIds(Input::get('tags')),
        ], new ThreadForm);
    }

    public function getMarkQuestionSolved($threadId, $solvedByReplyId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isQuestion() || ! $thread->isManageableBy(Auth::user())) {
            return Redirect::to('/');
        }

        $reply = $this->replies->requireById($solvedByReplyId);

        if ( ! $reply || $reply->thread_id != $thread->id) {
            return Redirect::to('/');
        }

        return App::make('Lio\Forum\Threads\ThreadUpdater')->update($this, $thread, [
            'solution_reply_id' => $reply->id,
        ]);
    }

    public function getMarkQuestionUnsolved($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isQuestion() || ! $thread->isManageableBy(Auth::user())) {
            return Redirect::to('/');
        }

        return App::make('Lio\Forum\Threads\ThreadUpdater')->update($this, $thread, [
            'solution_reply_id' => null,
        ]);
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

        if ( ! $thread->isManageableBy(Auth::user())) {
            return Redirect::to('/');
        }

        $this->createSections(Input::get('tags'));

        $this->title = "Delete Forum Thread";
        $this->view('forum.threads.delete', compact('thread'));
    }

    public function postDelete($threadId)
    {
        $thread = $this->threads->requireById($threadId);

        if ( ! $thread->isManageableBy(Auth::user())) {
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
        $query = Input::get('query');
        $results = App::make('Lio\Forum\Threads\ThreadSearch')->searchPaginated($query, $this->threadsPerPage);
        $results->appends(array('query' => $query));

        $this->createSections(Input::get('tags'));
        $this->title = "Forum Search";
        $this->view('forum.search', compact('query', 'results'));
    }

    // ------------------------- //
    private function createSections($currentSection = null)
    {
        $forumSections = App::make('Lio\Forum\SectionSidebarCreator')->createSidebar($currentSection);
        View::share(compact('forumSections'));
    }
}
