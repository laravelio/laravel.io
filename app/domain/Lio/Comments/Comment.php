<?php namespace Lio\Comments;

use Lio\Core\EloquentBaseModel;

class Comment extends EloquentBaseModel
{
    protected $table    = 'comments';
    protected $fillable = ['title', 'body', 'author_id', 'parent_id'];

    protected $validatorRules = [
        'body'      => 'required',
        'author_id' => 'required|exists:users,id',
    ];

    public function owner()
    {
        return $this->morphTo('owner');
    }

    public function author()
    {
        return $this->belongsTo('author');
    }

    public function parent()
    {
        return $this->belongsTo('Lio\Comments\Comment', 'parent_id');
    }

    public function mostRecentChild()
    {
        return $this->hasOne('Lio\Comments\Comment', 'most_recent_child_id');
    }
}