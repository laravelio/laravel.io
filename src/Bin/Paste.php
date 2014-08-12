<?php namespace Lio\Bin;

use Lio\Core\Entity;

class Paste extends Entity {

    protected $table      = 'pastes';
    protected $fillable   = ['description', 'code', 'author_id', 'parent_id'];
    protected $with       = ['comments'];
    protected $softDelete = true;

    public $presenter = 'Lio\Bin\PastePresenter';

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
}