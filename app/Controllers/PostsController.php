<?php namespace Controllers;

use Lio\Blog\TagRepository;
use Lio\Blog\PostRepository;

class PostsController extends BaseController
{
    private $posts;
    private $tags;

    public function __construct(PostRepository $posts, TagRepository $tags)
    {
        $this->tags = $tags;
        $this->posts = $posts;
    }

    public function getIndex()
    {
        $posts = $this->posts->getAll();
        $navTags = $this->tags->getAll();

        $this->view('posts.index', compact('posts', 'navTags'));
    }

    public function getShow($post)
    {
        $this->view('posts.show', compact('post'));
    }

    public function getTag($tag)
    {
        $navTags = $this->tags->getAll();

        $this->view('posts.tag', compact('tag', 'navTags'));
    }
}