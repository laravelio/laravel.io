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
    }

    public function getIndex()
    {
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));

        $threads = $this->comments->getForumThreadsByTagsPaginated($tags, $this->threadsPerPage);
        $threads->appends(['tags' => Input::get('tags')]);

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
        $thread = App::make('slugModel');

        $form = $this->comments->getForumReplyForm();

        if ( ! $form->isValid()) return $this->redirectBack(['errors' => $form->getErrors()]);

        $comment = $this->comments->getNew([
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
            'type'      => Comment::TYPE_FORUM,
        ]);

        if ( ! $comment->isValid()) return $this->redirectBack(['errors' => $comment->getErrors()]);

        $thread->children()->save($comment);

        return $this->redirectAction('ForumController@getThread', [$thread->slug->slug]);
    }

    public function getCreateThread()
    {
        $tags = $this->tags->getAllForForum();

        $this->view('forum.createthread', compact('tags'));
    }

    public function postCreateThread()
    {
        $form = $this->comments->getForumCreateForm();

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

        // store tags
        $tags = $this->tags->getTagsByIds(Input::get('tags'));
        $comment->tags()->sync($tags->lists('id'));

        // load new slug
        $commentSlug = $comment->slug()->first()->slug;

        return $this->redirectAction('ForumController@getThread', [$commentSlug]);
    }

    public function getEditThread($threadId)
    {
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        $tags = $this->tags->getAllForForum();
        $this->view('forum.editthread', compact('thread', 'tags'));
    }

    public function postEditThread($threadId)
    {
        $thread = $this->comments->requireForumThreadById($threadId);
        if (Auth::user()->id != $thread->author_id) return Redirect::to('/');

        // i hate everything about these controllers, it's awful
        $form = $this->comments->getForumCreateForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $thread->fill([
            'title'         => Input::get('title'),
            'body'          => Input::get('body'),
        ]);

        if ( ! $thread->isValid()) {
            return $this->redirectBack(['errors' => $thread->getErrors()]);
        }

        $this->comments->save($thread);

        // store tags
        $tags = $this->tags->getTagsByIds(Input::get('tags'));
        $thread->tags()->sync($tags->lists('id'));

        // load new slug
        $threadSlug = $thread->slug()->first()->slug;

        return $this->redirectAction('ForumController@getThread', [$threadSlug]);
    }

    // oh god it's so bad
    public function getEditComment($commentId)
    {
        $comment = $this->comments->requireForumThreadById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $this->view('forum.editcomment', compact('comment'));
    }

    public function postEditComment($commentId)
    {
        $comment = $this->comments->requireForumThreadById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');

        // i hate everything about these controllers, it's awful
        $form = $this->comments->getForumReplyForm();

        if ( ! $form->isValid()) return $this->redirectBack(['errors' => $form->getErrors()]);

        $comment->fill([
            'title' => Input::get('title'),
            'body'  => Input::get('body'),
        ]);

        if ( ! $comment->isValid()) return $this->redirectBack(['errors' => $comment->getErrors()]);

        $this->comments->save($comment);

        return $this->redirectAction('ForumController@getThread', [$comment->parent->slug->slug]);
    }

    public function getComment($thread, $commentId)
    {
        // Holy shit worst code ever made..
        // LYLAS!

        $perPage = $this->commentsPerPage;
        $comment = Comment::find($commentId);
        $before = Comment::where('parent_id', '=', $comment->parent_id)->where('created_at', '<', $comment->created_at)->count();

        $page = round($before / $perPage, 0, PHP_ROUND_HALF_DOWN) + 1;

        $url = action('ForumController@getThread', [$thread]);

        return Redirect::to($url . '?page=' . $page . '#comment-' . $commentId);

    }
}