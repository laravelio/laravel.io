<?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

use Lio\Tags\TagRepository;

class ForumController extends BaseController
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

    public function getComment($thread, $commentId)
    {
        // Holy shit worst code ever made..
        // LYLAS!
        $comment = Comment::findOrFail($commentId);
        $before = Comment::where('parent_id', '=', $comment->parent_id)->where('created_at', '<', $comment->created_at)->count();
        $page = round($before / $this->commentsPerPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        return Redirect::to(action('ForumThreadController@show', [$thread]) . '?page=' . $page . '#comment-' . $commentId);
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
        return Redirect::action('ForumThreadController@index');
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