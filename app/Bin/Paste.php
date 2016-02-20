<?php
namespace Lio\Bin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Lio\Core\Entity;
use McCool\LaravelAutoPresenter\HasPresenter;

class Paste extends Entity implements HasPresenter
{
    use SoftDeletes;

    protected $table    = 'pastes';
    protected $fillable = ['description', 'code', 'ip', 'author', 'parent', 'author_id', 'parent_id'];
    protected $with     = ['comments'];
    protected $dates    = ['deleted_at'];

    protected $validationRules = [
        'code' => 'required',
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo('Lio\Bin\Paste', 'parent_id');
    }

    public function comments()
    {
        return $this->morphMany('Lio\Comments\Comment', 'owner');
    }

    public function setAuthorAttribute($user)
    {
        if ( ! $user) return false;
        $this->author()->associate($user);
    }

    public function setParentAttribute($paste)
    {
        if ( ! $paste) return false;
        $this->parent()->associate($paste);
    }

    public function hasComments()
    {
        return (bool) $this->comments->count() > 0;
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return PastePresenter::class;
    }
}
