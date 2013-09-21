<?php namespace Lio\Comments;

use McCool\LaravelSlugs\SlugInterface;
use Lio\Core\EloquentBaseModel;
use Str;

class Comment extends EloquentBaseModel implements SlugInterface
{
    protected $table    = 'comments';
    protected $fillable = ['title', 'body', 'author_id', 'parent_id', 'category_slug', 'owner_id', 'owner_type'];
    protected $with     = ['author'];
    
    public $presenter = 'Lio\Comments\CommentPresenter';

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
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo('Lio\Comments\Comment', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Lio\Comments\Comment', 'parent_id');
    }

    public function mostRecentChild()
    {
        return $this->belongsTo('Lio\Comments\Comment', 'most_recent_child_id');
    }

    public function setMostRecentChild(Comment $comment)
    {
        $this->most_recent_child_id = $comment->id;
        $this->updateChildCount();
        $this->save();
    }
    
    public function updateChildCount()
    {
        if ($this->exists) {
            $this->child_count = $this->children()->count();
        }
    }

    // SlugInterface
    public function slug()
    {
        return $this->morphOne('McCool\LaravelSlugs\Slug', 'owner');
    }

    public function getSlugString()
    {
        if ($this->owner_type == 'Lio\Forum\ForumCategory') {
            return $this->getForumPostSlugString();
        }
    }
    //

    private function getForumPostSlugString()
    {
        if (empty($this->title)) {
            return '';
        }
        
        $date = date("m-d-Y", strtotime($this->created_at));

        return Str::slug("{$date} - {$this->title}");
    }
}