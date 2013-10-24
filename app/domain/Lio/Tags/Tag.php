<?php namespace Lio\Tags;

use Lio\Core\EloquentBaseModel;

class Tag extends EloquentBaseModel
{
    protected $table    = 'tags';
    protected $fillable = ['name', 'slug'];

    public $timestamps = false;

    protected $validationRules = [
        'name' => 'required',
        'slug' => 'required',
    ];
}