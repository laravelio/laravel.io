<?php namespace Controllers;

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;
use Lio\Tags\TagRepository;
use Lio\Forum\ForumCategoryRepository;
use App, Auth, Input;

class ForumController extends BaseController
{
    private $categories;
    private $comments;

    public function __construct(CommentRepository $comments, TagRepository $tags, ForumCategoryRepository $categories)
    {
        $this->comments   = $comments;
        $this->categories = $categories;
        $this->tags       = $tags;
    }

    public function getIndex()
    {
        $tags = $this->tags->getAllTagsBySlug(Input::get('tags'));      

        $threads = $this->comments->getForumThreadsByTagsPaginated($tags, 1);
        $threads->appends(['tags' => Input::get('tags')]);

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
        $tags = $this->tags->getAll();

        $this->view('forum.createthread', compact('tags'));
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

        // store tags
        $tags = $this->tags->getTagsByIds(Input::get('tags'));
        $comment->tags()->sync($tags->lists('id'));

        // load new slug
        $commentSlug = $comment->slug()->first()->slug;

        return $this->redirectAction('Controllers\ForumController@getThread', [$commentSlug]);
    }
}