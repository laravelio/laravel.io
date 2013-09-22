<?php namespace Controllers;

use Lio\Forum\ForumCategoryRepository;
use Lio\Comments\CommentRepository;
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
        $categories = $this->categories->getForumIndex();

        $this->view('forum.index', compact('categories'));
    }

    public function getCategory($categorySlug)
    {
        $category = $this->categories->requireCategoryBySlug($categorySlug);
        $threads  = $this->comments->getForumThreadsByCategoryPaginated($category);

        $this->view('forum.category', compact('category', 'threads'));
    }

    public function getThread($categorySlug)
    {
        $thread = App::make('slugModel');
        $category = $thread->owner;
        $comments = $this->comments->getThreadCommentsPaginated($thread);

        $this->view('forum.thread', compact('thread', 'category', 'comments'));
    }

    public function postThread($categorySlug)
    {
        $thread = App::make('slugModel');

        $category = $this->categories->requireCategoryBySlug($categorySlug);

        $form = $this->categories->getReplyForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $comment = $this->comments->getNew([
            'body'          => Input::get('body'),
            'author_id'     => Auth::user()->id,
            'parent_id'     => $thread->id,
            'type'          => Comment::TYPE_FORUM,
        ]);

        if ( ! $comment->isValid()) {
            return $this->redirectBack(['errors' => $comment->getErrors()]);
        }

        $thread->children()->save($comment);

        return $this->redirectAction('Controllers\ForumController@getThread', [$categorySlug, $thread->slug->slug]);
    }

    public function getCreateThread($categorySlug)
    {
        $category = $this->categories->requireCategoryBySlug($categorySlug);

        $this->view('forum.createthread', compact('category'));
    }

    public function postCreateThread($categorySlug)
    {
        $category = $this->categories->requireCategoryBySlug($categorySlug);

        $form = $this->categories->getThreadForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $comment = $this->comments->getNew([
            'title'         => Input::get('title'),
            'body'          => Input::get('body'),
            'author_id'     => Auth::user()->id,
            'category_slug' => $category->slug,
            'type'          => Comment::TYPE_FORUM,
        ]);

        if ( ! $comment->isValid()) {
            return $this->redirectBack(['errors' => $comment->getErrors()]);
        }

        $category->rootThreads()->save($comment);

        $commentSlug = $comment->slug()->first()->slug;

        return $this->redirectAction('Controllers\ForumController@getThread', [$categorySlug, $commentSlug]);
    }
}