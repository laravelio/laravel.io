<?php namespace Controllers;

use Lio\Forum\ForumCategoryRepository;
use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;
use App, Auth, Input;

class ForumController extends BaseController
{
    private $categories;
    private $comments;

    public function __construct(ForumCategoryRepository $categories, CommentRepository $comments)
    {
        $this->categories = $categories;
        $this->comments   = $comments;
    }

    public function getIndex()
    {
        $threads = $this->comments->getForumThreadsByTagsPaginated();
        $this->view('forum.index', compact('threads'));
    }

    public function getThread()
    {
        $thread   = App::make('slugModel');
        $comments = $this->comments->getThreadCommentsPaginated($thread);

        $this->view('forum.thread', compact('thread', 'comments'));
    }

    public function postThread()
    {
        $thread = App::make('slugModel');

        $form = $this->categories->getReplyForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $comment = $this->comments->getNew([
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
            'type'      => Comment::TYPE_FORUM,
        ]);

        if ( ! $comment->isValid()) {
            return $this->redirectBack(['errors' => $comment->getErrors()]);
        }

        $thread->children()->save($comment);

        return $this->redirectAction('Controllers\ForumController@getThread', [$thread->slug->slug]);
    }

    public function getCreateThread()
    {
        $this->view('forum.createthread');
    }

    public function postCreateThread()
    {
        $form = $this->categories->getThreadForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $comment = $this->comments->getNew([
            'title'         => Input::get('title'),
            'body'          => Input::get('body'),
            'author_id'     => Auth::user()->id,
            'type'          => Comment::TYPE_FORUM,
        ]);

        if ( ! $comment->isValid()) {
            return $this->redirectBack(['errors' => $comment->getErrors()]);
        }

        $this->comments->save($comment);

        $commentSlug = $comment->slug()->first()->slug;

        return $this->redirectAction('Controllers\ForumController@getThread', [$commentSlug]);
    }
}