<?php namespace Controllers;

use Lio\Blog\PostRepository;

class PostsController extends BaseController
{
    private $posts;
    private $categories;

    public function __construct(PostRepository $posts, CategoryRepository $categories)
    {
        $this->posts = $posts;
        $this->categories = $categories;
    }

    public function getIndex()
    {
        $posts = $this->posts->getAll();
        $navCategories = $this->categories->getAll();;

        $this->view('posts.index', compact('posts', 'navCategories'));
    }

    public function getShow($post)
    {
        $this->view('posts.show', compact('post'));
    }

    public function getCategory($category)
    {
        $navCategories = $this->categories->getAll();

        $this->view('posts.category', compact('category', 'navCategories'));
    }
}