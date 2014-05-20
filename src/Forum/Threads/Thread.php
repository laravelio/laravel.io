<?php namespace Lio\Forum\Threads;

use Lio\Events\EventGenerator;
use Illuminate\Database\Eloquent\Model;
use Lio\Tags\Taggable;

class Thread extends Model
{
    use Taggable;

    protected $table = 'forum_threads';
    protected $guarded = [];
    protected $softDelete = true;

    public static $laravelVersions = [
        4 => "Laravel 4.x",
        3 => "Laravel 3.x",
        0 => "Doesn't Matter",
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function getTitleAttribute()
    {
        return ($this->isSolved() ? '[SOLVED] ' : '') . $this->subject;
    }

    public function getLaravelVersions()
    {
        return $this->laravelVersions;
    }

    public function isQuestion()
    {
        return $this->is_question;
    }

    public function isSolved()
    {
        return $this->isQuestion() && ! is_null($this->solution_reply_id);
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

    public function isReplyTheSolution($reply)
    {
        return $reply->id == $this->solution_reply_id;
    }
}
