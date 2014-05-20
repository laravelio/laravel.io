<?php namespace Lio\Articles\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'article_comments';
    protected $with = ['author'];
    protected $guarded = [];
    protected $softDelete = true;

    public function article()
    {
        return $this->belongsTo('Lio\Articles\Entities\Article', 'article_id');
    }

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\Member', 'author_id');
    }

    public function edit($content)
    {
        $this->content = $content;
    }
} 
