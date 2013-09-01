<?php namespace Lio\Bin;

use Lio\Core\EloquentBaseModel;

class Comment extends EloquentBaseModel {

    protected $table    = 'paste_comments';
    protected $fillable = ['title', 'content'];

    protected $validatorRules = [
        'title'   => 'required',
        'content' => 'required',
    ];

    public function paste()
    {
        return $this->belongsTo('Lio\Bin\Paste');
    }

}