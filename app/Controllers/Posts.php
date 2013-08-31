<?php namespace Controllers;

use Lio\Blog\Post;
use Lio\Blog\Category;

class Posts extends Base
{
    public function getIndex()
    {
        $posts = Post::orderBy('published_at', 'desc')->where('show_in_index', '=', 1)->get();
        $navCategories = Category::all();

        return $this->view('posts.index', compact('posts', 'navCategories'));
    }

    public function getShow($post)
    {
        return $this->view('posts.show', compact('post'));
    }

    public function getCategory($category)
    {
        $navCategories = Category::all();

        return $this->view('posts.category', compact('category', 'navCategories'));
    }
}