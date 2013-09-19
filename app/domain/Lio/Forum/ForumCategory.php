<?php namespace Lio\Forum;

use Lio\Core\EloquentBaseModel;

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
        return $this->morphMany('Lio\Comments\Comment', 'owner')->where('comments.parent_id', '=', 0);
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