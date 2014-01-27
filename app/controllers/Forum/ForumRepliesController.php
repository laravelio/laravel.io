<?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;
use Lio\Tags\TagRepository;
use Lio\Forum\SectionCountManager;
use Lio\Forum\ForumReplyForm;

class ForumRepliesController extends BaseController implements
    \Lio\Forum\ForumReplyCreatorObserver,
    \Lio\Forum\ForumReplyUpdaterObserver,
    \Lio\Forum\ForumReplyDeleterObserver
{
    protected $comments;
    protected $tags;
    protected $sections;

    protected $threadsPerPage = 20;
    protected $commentsPerPage = 20;

    public function __construct(CommentRepository $comments, TagRepository $tags, SectionCountManager $sections)
    {
        $this->comments = $comments;
        $this->tags     = $tags;
        $this->sections = $sections;

        $this->prepareViewData();
    }

    // bounces the user to the correct page of a thread for the indicated comment
    public function getCommentRedirect($thread, $commentId)
    {
        // refactor this
        $comment = Comment::findOrFail($commentId);
        $numberCommentsBefore = Comment::where('parent_id', '=', $comment->parent_id)->where('created_at', '<', $comment->created_at)->count();
        $page = round($numberCommentsBefore / $this->commentsPerPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        return Redirect::to(action('ForumThreadsController@getShowThread', [$thread]) . "?page={$page}#comment-{$commentId}");
    }

    // reply deletion
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
    public function forumReplyDeleted($thread)
    {
        return Redirect::action('ForumThreadsController@getShowThread', [$thread->slug->slug]);
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
        return $this->redirectAction('ForumThreadsController@getShowThread', [$reply->parent()->first()->slug->slug]);
    }

    public function forumReplyUpdated($reply)
    {
        return $this->redirectAction('ForumThreadsController@getShowThread', [$reply->parent->slug->slug]);
    }

    // ------------------------- //
    private function prepareViewData()
    {
        $forumSections = Config::get('forum.sections');
        $sectionCounts = $this->sections->getCounts(Session::get('forum_last_visited'));
        View::share(compact('forumSections', 'sectionCounts'));
    }
}