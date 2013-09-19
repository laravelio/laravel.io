<?php namespace Lio\Blog;

use Lio\Core\EloquentBaseModel;

class Tag extends EloquentBaseModel
{
    protected $table    = 'tags';
    protected $fillable = ['name', 'slug', 'type'];

    protected $validationRules = [
        'name' => 'required',
        'slug' => 'required',
    ];

    public function posts()
    {
        return $this->belongsToMany('Lio\Blog\Post', 'post_tag', 'tag_id', 'post_id')->orderBy('published_at', 'desc');
    }
}