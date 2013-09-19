<?php namespace Lio\Forum;

use Lio\Core\EloquentBaseModel;
use Lio\Comments\Comment;

class ForumCategory extends EloquentBaseModel
{
    protected $table    = 'forum_categories';
    protected $fillable = ['title', 'description', 'show_in_index'];

    public $presenter = 'Lio\Forum\ForumCategoryPresenter';

    protected $validatorRules = [
        'title' => 'required'
    ];

    public function rootThreads()
    {
        return $this->morphMany('Lio\Comments\Comment', 'owner')->whereNull('comments.parent_id');
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

    private function updateChildCount()
    {
        if ($this->exists) {
            $this->child_count = $this->rootThreads()->count();
        }
    }
}