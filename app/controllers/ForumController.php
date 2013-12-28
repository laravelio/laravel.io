<?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

use Lio\Tags\TagRepository;
use Lio\Forum\ForumSectionCountManager;

use Lio\Forum\ForumThreadForm;
use Lio\Forum\ForumReplyForm;

class ForumController extends BaseController implements
    \Lio\Forum\ForumThreadCreatorObserver,
    \Lio\Forum\ForumThreadUpdaterObserver,
    \Lio\Forum\ForumThreadDeleterObserver,
    \Lio\Forum\ForumReplyCreatorObserver,
    \Lio\Forum\ForumReplyUpdaterObserver,
    \Lio\Forum\ForumReplyDeleterObserver
{
    protected $comments;
    protected $tags;
    protected $sections;

    protected $threadsPerPage = 20;
    protected $commentsPerPage = 20;

    public function __construct(CommentRepository $comments, TagRepository $tags, ForumSectionCountManager $sections)
    {
        $this->comments = $comments;
        $this->tags     = $tags;
        $this->sections = $sections;

        $this->prepareViewData();
    }

    // show thread list
    public function getIndex()
    {
        // update user timestamp
        View::share('last_visited_timestamp', App::make('Lio\Forum\ForumSectionCountManager')->updatedAndGetLastVisited(Input::get('tags')));

        // query tags and retrieve the appropriate threads
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $threads = $this->comments->getForumThreadsByTagsPaginated($tags, $this->threadsPerPage);

        // add the tag string to each pagination link
        $threads->appends(['tags' => Input::get('tags')]);

        $this->view('forum.index', compact('threads'));
    }

    // show a thread
    public function getShowThread()
    {
        $thread = App::make('slugModel');
        $comments = $this->comments->getThreadCommentsPaginated($thread, $this->commentsPerPage);

        $this->view('forum.showthread', compact('thread', 'comments'));
    }

    // create a thread
    public function getCreateThread()
    {
        $tags = $this->tags->getAllForForum();
        $versions = Comment::$laravelVersions;

        $this->view('forum.createthread', compact('tags', 'versions'));
    }

    public function postCreateThread()
    {
        $tags = $this->tags->getTagsByIds(Input::get('tags'));

        return App::make('Lio\Forum\ForumThreadCreator')->create($this, [
            'title'           => Input::get('title'),
            'body'            => Input::get('body'),
            'author_id'       => Auth::user()->id,
            'laravel_version' => Input::get('laravel_version'),
            'tags'            => $tags,
        ], new ForumThreadForm);
    }

    // edit a thread
    public function getEditThread($threadId)
    {
        // check ownership
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        $tags = $this->tags->getAllForForum();
        $versions = Comment::$laravelVersions;

        $this->view('forum.editthread', compact('thread', 'tags', 'versions'));
    }

    public function postEditThread($threadId)
    {
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        $tags = $this->tags->getTagsByIds(Input::get('tags'));

        return App::make('Lio\Forum\ForumThreadUpdater')->update($this, $thread, [
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
        return $this->redirectAction('ForumController@getShowThread', [$thread->slug()->first()->slug]);
    }

    public function forumThreadUpdated($thread)
    {
        return $this->redirectAction('ForumController@getShowThread', [$thread->slug->slug]);
    }

    // bounces the user to the correct page of a thread for the indicated comment
    public function getCommentRedirect($thread, $commentId)
    {
        // refactor this
        $comment = Comment::findOrFail($commentId);
        $numberCommentsBefore = Comment::where('parent_id', '=', $comment->parent_id)->where('created_at', '<', $comment->created_at)->count();
        $page = round($numberCommentsBefore / $this->commentsPerPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        return Redirect::to(action('ForumController@getShowThread', [$thread]) . "?page={$page}#comment-{$commentId}");
    }

    // thread deletion
    public function getDelete($commentId)
    {
        // user owns the comment
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');

        $this->view('forum.delete', compact('comment'));
    }

    public function postDelete($commentId)
    {
        // user owns the comment
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');

        if ($comment->parent) {
            return App::make('Lio\Forum\ForumReplyDeleter')->delete($this, $comment);
        }
        return App::make('Lio\Forum\ForumThreadDeleter')->delete($this, $comment);
    }

    // observer methods
    public function forumThreadDeleted()
    {
        return Redirect::action('ForumController@getIndex');
    }

    public function forumReplyDeleted($thread)
    {
        return Redirect::action('ForumController@getShowThread', [$thread->slug->slug]);
    }

    // forum search
    public function getSearch()
    {
        View::share('last_visited_timestamp', App::make('Lio\Forum\ForumSectionCountManager')->updatedAndGetLastVisited(Input::get('tags')));

        $query = Input::get('query');
        $results = App::make('Lio\Comments\ForumSearch')->searchPaginated($query, $this->threadsPerPage);

        $this->view('forum.search', compact('query', 'results'));
    }

    // reply to a thread
    public function postCreateReply()
    {
        $thread = App::make('slugModel');

        return App::make('Lio\Forum\ForumReplyCreator')->create($this, [
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
        ], $thread->id, new ForumReplyForm);
    }

    // edit a reply
    public function getEditReply($replyId)
    {
        $reply = $this->comments->requireForumThreadById($replyId);
        if (Auth::user()->id != $reply->author_id) return Redirect::to('/');

        $this->view('forum.editreply', compact('reply'));
    }

    public function postEditReply($replyId)
    {
        $reply = $this->comments->requireForumThreadById($replyId);
        if (Auth::user()->id != $reply->author_id) return Redirect::to('/');

        return App::make('Lio\Forum\ForumReplyUpdater')->update($reply, $this, [
            'body' => Input::get('body'),
        ], new ForumReplyForm);
    }

    // observer methods
    public function forumReplyValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function forumReplyCreated($reply)
    {
        // awful demeter chain - clean up
        return $this->redirectAction('ForumController@getShowThread', [$reply->parent()->first()->slug->slug]);
    }

    public function forumReplyUpdated($reply)
    {
        return $this->redirectAction('ForumController@getShowThread', [$reply->parent->slug->slug]);
    }

    // ------------------------- //
    private function prepareViewData()
    {
        $forumSections = Config::get('forum.sections');
        $sectionCounts = $this->sections->getCounts(Session::get('forum_last_visited'));
        View::share(compact('forumSections', 'sectionCounts'));
    }
}