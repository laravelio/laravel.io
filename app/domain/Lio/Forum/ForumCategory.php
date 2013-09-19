<?php namespace Lio\Forum;

use Lio\Core\EloquentBaseModel;

class ForumCategory extends EloquentBaseModel
{
    protected $table    = 'forum_categories';
    protected $fillable = ['title', 'description', 'show_in_index'];

    protected $validatorRules = [
        'title' => 'required'
    ];
}