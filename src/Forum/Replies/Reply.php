<?php namespace Lio\Forum\Replies;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'forum_replies';
    protected $guarded = [];
    protected $softDelete = true;

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function isManageableBy($member)
    {
        if ( ! $member) {
            return false;
        }
        return $this->isOwnedBy($member) || $member->isForumAdmin();
    }

    public function isOwnedBy($member)
    {
        if ( ! $member) {
            return false;
        }
        return $member->id == $this->author_id;
    }
}
