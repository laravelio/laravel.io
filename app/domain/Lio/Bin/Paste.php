<?php namespace Lio\Bin;

use Lio\Core\EloquentBaseModel;

class Paste extends EloquentBaseModel {

    protected $table    = 'pastes';
    protected $fillable = ['content'];

    protected $validationRules = [
        'content' => 'required',
    ];

    public function comments()
    {
        return $this->hasMany('Lio\Bin\Comment');
    }

}