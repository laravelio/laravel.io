<?php namespace Lio\Tags;

use Lio\Core\EloquentBaseModel;

class Tag extends EloquentBaseModel
{
    protected $table    = 'tags';
    protected $fillable = ['name', 'slug'];

    protected $validationRules = [
        'name' => 'required',
        'slug' => 'required',
    ];
}