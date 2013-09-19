<?php namespace Controllers;

use Lio\Forum\ForumCategoryRepository;
use App;

class ForumController extends BaseController
{
    private $categories;

    public function __construct(ForumCategoryRepository $categories)
    {
        $this->categories = $categories;
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

    public function getThread($thread)
    {
        dd($thread);
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

        die('cat');
    }
}