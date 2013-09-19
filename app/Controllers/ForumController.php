<?php namespace Controllers;

use Lio\Forum\ForumCategoryRepository;

class ForumController extends BaseController
{
    private $forumCategories;

    public function __construct(ForumCategoryRepository $forumCategories)
    {
        $this->forumCategories = $forumCategories;
    }

    public function getIndex()
    {
        $forumCategories = $this->forumCategories->getForumIndex();

        $this->view('forum.index', compact('forumCategories'));
    }

    public function category($categorySlug)
    {
        $forumCategory = $this->forumCategories->getCategoryPageBySlug($categorySlug);

        $this->view('forum.category', compact('forumCategory'));
    }
}