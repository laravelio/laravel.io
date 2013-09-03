<?php namespace Lio\Blog;

use Lio\Core\EloquentBaseModel;

class Category extends EloquentBaseModel
{
    protected $table    = 'categories';
    protected $fillable = ['name', 'slug', 'type'];

    protected $validationRules = [
        'name' => 'required',
        'slug' => 'required',
    ];

    public function posts()
    {
        return $this->belongsToMany('Lio\Blog\Post', 'category_post', 'category_id', 'post_id')->orderBy('published_at', 'desc');
    }
}