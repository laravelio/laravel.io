<?php namespace Lio\Bin;

use Lio\Core\EloquentBaseModel;

class Comment extends EloquentBaseModel {

    protected $table    = 'paste_comments';
    protected $fillable = ['comment', 'author_id'];

    protected $validatorRules = [
        'comment'   => 'required',
        'author_id' => 'required|exists:users,id',
    ];

    public function paste()
    {
        return $this->belongsTo('Lio\Bin\Paste');
    }

}