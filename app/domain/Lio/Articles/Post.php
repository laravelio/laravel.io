<?php namespace Lio\Blog;

use Lio\Core\EloquentBaseModel;

class Post extends EloquentBaseModel
{
    protected $table    = 'posts';
    protected $with     = ['author'];
    protected $fillable = ['author_id', 'title', 'body', 'note', 'slug', 'disqus_thread_id', 'status', 'published_at'];
    public $presenter   = 'Lio\Blog\PostPresenter';

    protected $validationRules = [
        'author_id' => 'required|exists:users,id',
        'title'     => 'required',
        'slug'      => 'required',
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Blog\Tag', 'post_tag');
    }
}