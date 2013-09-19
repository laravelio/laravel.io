<?php namespace Controllers\Admin;

use Lio\Blog\Tag;
use Lio\Blog\Post;
use Controllers\BaseController;

class PostsController extends BaseController
{
    public function getIndex()
    {
        // $posts = Post::orderBy('published_at', 'desc')->where('show_in_index', '=', 1)->get();
        // $navTags = Tag::all();

        // $this->view('admin.posts.index', compact('posts', 'navTags'));
        return 'cats';
    }
}
