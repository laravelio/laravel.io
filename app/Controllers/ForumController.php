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

        $this->beforeFilter('auth', ['only' => ['getCreateThread', 'postCreateThread', 'postThread']]);
    }

    public function getIndex()
    {
        $categories = $this->categories->getForumIndex();

        $this->view('forum.index', compact('categories'));
    }

    public function getCategory($categorySlug)
    {
        $category = $this->categories->requireCategoryPageBySlug($categorySlug);

        $this->view('forum.category', compact('category'));
    }

    public function getThread($categorySlug)
    {
        $thread = App::make('slugModel');


        $this->view('forum.thread', compact('thread'));
    }

    public function postThread($thread)
    {

    }

    public function getCreateThread($categorySlug)
    {
        $category = $this->categories->requireCategoryPageBySlug($categorySlug);

        $this->view('forum.createthread', compact('category'));
    }

    public function postCreateThread($categorySlug)
    {
        $category = $this->categories->requireCategoryPageBySlug($categorySlug);

        $form = $this->categories->getThreadForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $comment = $this->comments->getNew([
            'title'     => Input::get('title'),
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
        ]);

        if ( ! $comment->isValid()) {
            return $this->redirectBack(['errors' => $comment->getErrors()]);
        }

        $category->rootThreads()->save($comment);

        die('comment created');
        return $this->redirectAction('Controllers\ForumController@getThread', [$comment->slug]);
    }
}