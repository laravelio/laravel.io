<?php

namespace Lio\Http\Controllers\Forum;

use Auth;
use Config;
use Input;
use Lio\Forum\Replies\ReplyCreatorListener;
use Lio\Forum\Replies\ReplyDeleterListener;
use Lio\Forum\Replies\ReplyForm;
use Lio\Forum\Replies\ReplyPresenter;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Replies\ReplyUpdaterListener;
use Lio\Forum\Threads\ThreadRepository;
use Lio\Http\Controllers\Controller;
use Lio\Tags\TagRepository;
use Request;
use View;

class ForumRepliesController extends Controller implements ReplyCreatorListener, ReplyUpdaterListener, ReplyDeleterListener
{
    protected $tags;
    protected $sections;
    protected $repliesPerPage = 20;

    public function __construct(ThreadRepository $threads, ReplyRepository $replies, TagRepository $tags)
    {
        $this->threads = $threads;
        $this->replies = $replies;
        $this->tags = $tags;

        $this->prepareViewData();
    }

    // bounces the user to the correct page of a thread for the indicated comment
    public function getReplyRedirect($threadSlug, $replyId)
    {
        $reply = $this->replies->requireById($replyId);

        if (!$reply->isManageableBy(Auth::user())) {
            return redirect()->home();
        }

        $generator = app('Lio\Forum\Replies\ReplyQueryStringGenerator');
        $queryString = $generator->generate($reply, $this->repliesPerPage);

        return redirect(action('Forum\ForumThreadsController@getShowThread', $threadSlug).$queryString);
    }

    // reply to a thread
    public function postCreateReply($threadSlug)
    {
        $thread = $this->threads->requireBySlug($threadSlug);

        return app('Lio\Forum\Replies\ReplyCreator')->create($this, [
            'body'   => Input::get('body'),
            'author' => Auth::user(),
            'ip'     => Request::ip(),
        ], $thread->id, new ReplyForm());
    }

    public function replyCreationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function replyCreated($reply)
    {
        $replyPresenter = new ReplyPresenter($reply);

        return $this->redirectTo($replyPresenter->url);
    }

    // edit a reply
    public function getEditReply($replyId)
    {
        $reply = $this->replies->requireById($replyId);

        if (!$reply->isManageableBy(Auth::user())) {
            return redirect()->home();
        }

        return view('forum.replies.edit', compact('reply'));
    }

    public function postEditReply($replyId)
    {
        $reply = $this->replies->requireById($replyId);

        if (!$reply->isManageableBy(Auth::user())) {
            return redirect()->home();
        }

        return app('Lio\Forum\Replies\ReplyUpdater')->update($reply, $this, [
            'body' => Input::get('body'),
        ], new ReplyForm());
    }

    // observer methods
    public function replyUpdateError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function replyUpdated($reply)
    {
        $replyPresenter = new ReplyPresenter($reply);

        return $this->redirectTo($replyPresenter->url);
    }

    // reply deletion
    public function getDelete($replyId)
    {
        $reply = $this->replies->requireById($replyId);

        if (!$reply->isManageableBy(Auth::user())) {
            return redirect()->home();
        }

        return view('forum.replies.delete', compact('reply'));
    }

    public function postDelete($replyId)
    {
        $reply = $this->replies->requireById($replyId);

        if (!$reply->isManageableBy(Auth::user())) {
            return redirect()->home();
        }

        return app('Lio\Forum\Replies\ReplyDeleter')->delete($this, $reply);
    }

    // observer methods
    public function replyDeleted($thread)
    {
        return redirect()->action('Forum\ForumThreadsController@getShowThread', $thread->slug);
    }

    private function prepareViewData()
    {
        $forumSections = Config::get('forum.sections');

        View::share(compact('forumSections'));
    }
}
