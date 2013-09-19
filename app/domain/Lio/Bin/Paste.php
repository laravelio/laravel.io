<?php namespace Lio\Bin;

use Lio\Core\EloquentBaseModel;

class Paste extends EloquentBaseModel {

    protected $table    = 'pastes';
    protected $fillable = ['description', 'code', 'author_id', 'parent_id'];
    protected $with     = ['comments'];

    protected $validationRules = [
        'code' => 'required',
    ];

    public function parent()
    {
        return $this->belongsTo('Lio\Bin\Paste', 'parent_id');
    }
}