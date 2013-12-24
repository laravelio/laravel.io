<?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

use Lio\Tags\TagRepository;

use Lio\Forum\ForumThreadForm;
use Lio\Forum\ForumReplyForm;
use Lio\Forum\ForumThreadCreatorObserver;
use Lio\Forum\ForumThreadUpdaterObserver;
use Lio\Forum\ForumReplyCreatorObserver;
use Lio\Forum\ForumReplyUpdaterObserver;

class ForumController extends BaseController implements ForumThreadCreatorObserver, ForumThreadUpdaterObserver, ForumReplyCreatorObserver, ForumReplyUpdaterObserver
{
    protected $categories;
    protected $comments;

    protected $threadsPerPage = 20;
    protected $commentsPerPage = 20;

    public function __construct(CommentRepository $comments, TagRepository $tags)
    {
        $this->comments = $comments;
        $this->tags     = $tags;

        View::share('forumSections', Config::get('forum.sections'));
        $this->setNewSectionCounts();
    }

    public function getIndex()
    {
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $threads = $this->comments->getForumThreadsByTagsPaginated($tags, $this->threadsPerPage);
        $threads->appends(['tags' => Input::get('tags')]);
        $this->updateUserLastVisited();
        $this->view('forum.index', compact('threads'));
    }

    public function getThread()
    {
        $thread   = App::make('slugModel');
        $comments = $this->comments->getThreadCommentsPaginated($thread, $this->commentsPerPage);
        $this->view('forum.thread', compact('thread', 'comments'));
    }

    public function postThread()
    {
        return App::make('Lio\Forum\ForumReplyCreator')->create($this, [
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
            'type'      => Comment::TYPE_FORUM,
            'thread'    => App::make('slugModel'),
        ], new ForumReplyForm);
    }

    public function forumReplyValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function forumReplyCreated($reply)
    {
        // update cache for sidebar counts
        $timestamps = App::make('Lio\Caching\ForumSectionTimestampFetcher')->cacheSections(Config::get('forum.sections'));
        Cache::put('forum_sidebar_timestamps', $timestamps, 1440);
        // awful demeter chain - clean up
        return $this->redirectAction('ForumController@getThread', [$reply->parent()->first()->slug->slug]);
    }

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
            'type'            => Comment::TYPE_FORUM,
            'laravel_version' => Input::get('laravel_version'),
            'tags'            => $tags,
        ], new ForumThreadForm);
    }

    public function forumThreadValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function forumThreadCreated($thread)
    {
        $timestamps = App::make('Lio\Caching\ForumSectionTimestampFetcher')->cacheSections(Config::get('forum.sections'));
        Cache::put('forum_sidebar_timestamps', $timestamps, 1440);
        return $this->redirectAction('ForumController@getThread', [$thread->slug()->first()->slug]);
    }

    public function getEditThread($threadId)
    {
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        $tags = $this->tags->getAllForForum();
        $versions = \Lio\Comments\Comment::$laravelVersions;

        $this->view('forum.editthread', compact('thread', 'tags', 'versions'));
    }

    public function postEditThread($threadId)
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

    public function forumThreadUpdated($thread)
    {
        return $this->redirectAction('ForumController@getThread', [$thread->slug->slug]);
    }

    // oh god it's so bad
    public function getEditComment($commentId)
    {
        $comment = $this->comments->requireForumThreadById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $this->view('forum.editcomment', compact('comment'));
    }

    public function postEditComment($replyId)
    {
        $reply = $this->comments->requireForumThreadById($replyId);
        if (Auth::user()->id != $reply->author_id) return Redirect::to('/');

        return App::make('Lio\Forum\ForumReplyUpdater')->update($reply, $this, [
            'body'      => Input::get('body'),
        ], new ForumReplyForm);
    }

    public function forumReplyUpdated($reply)
    {
        return $this->redirectAction('ForumController@getThread', [$reply->parent->slug->slug]);
    }

    public function getComment($thread, $commentId)
    {
        // Holy shit worst code ever made..
        // LYLAS!
        $comment = Comment::findOrFail($commentId);
        $before = Comment::where('parent_id', '=', $comment->parent_id)->where('created_at', '<', $comment->created_at)->count();
        $page = round($before / $this->commentsPerPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        return Redirect::to(action('ForumController@getThread', [$thread]) . '?page=' . $page . '#comment-' . $commentId);
    }

    // does the awful code ever end?
    public function getDelete($commentId)
    {
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $this->view('forum.delete', compact('comment'));
    }

    public function postDelete($commentId)
    {
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $comment->delete();
        return Redirect::action('ForumController@getIndex');
    }

    public function getSearch()
    {
        $query = Input::get('query');
        $results = App::make('Lio\Comments\ForumSearch')->searchPaginated($query, $this->threadsPerPage);
        $this->updateUserLastVisited();
        $this->view('forum.search', compact('query', 'results'));
    }

    private function updateUserLastVisited()
    {
        $forumLastVisited = Session::get('forum_last_visited');
        $tags = Input::get('tags');

        if (is_array($forumLastVisited)) {
            View::share('last_visited_timestamp', isset($forumLastVisited[$tags]) ? $forumLastVisited[$tags] : 0);
            $forumLastVisited[$tags] = strtotime('now');
        } else {
            View::share('last_visited_timestamp', 0);
            $forumLastVisited = [$tags => strtotime('now')];
        }

        Session::put('forum_last_visited', $forumLastVisited);
    }

    private function setNewSectionCounts()
    {
        $timestamps = Cache::rememberForever('forum_sidebar_timestamps', function() {
            return App::make('Lio\Caching\ForumSectionTimestampFetcher')->cacheSections(Config::get('forum.sections'));
        });
        $calculator = new Lio\Caching\UserForumSectionUpdateCountCalculator(Config::get('forum.sections'), Session::get('forum_last_visited'), $timestamps);
        $sectionCounts = $calculator->getCounts();
        View::share('sectionCounts', $sectionCounts);
    }
}