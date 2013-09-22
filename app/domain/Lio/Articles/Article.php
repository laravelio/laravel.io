<?php namespace Lio\Articles;

use Lio\Core\EloquentBaseModel;

class Article extends EloquentBaseModel
{
    protected $table    = 'articles';
    protected $with     = ['author'];
    protected $fillable = ['author_id', 'title', 'body', 'status'];
    
    public $presenter   = 'Lio\Articles\ArticlePresenter';

    protected $validationRules = [
        'author_id' => 'required|exists:users,id',
        'title'     => 'required',
        'body'      => 'required',
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }
}