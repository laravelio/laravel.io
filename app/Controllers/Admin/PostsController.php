<?php namespace Controllers\Admin;

use Lio\Blog\Post;
use Lio\Blog\Category;
use Controllers\BaseController;

class PostsController extends BaseController
{
    public function getIndex()
    {
        // $posts = Post::orderBy('published_at', 'desc')->where('show_in_index', '=', 1)->get();
        // $navCategories = Category::all();

        // $this->view('admin.posts.index', compact('posts', 'navCategories'));
        return 'cats';
    }
}
