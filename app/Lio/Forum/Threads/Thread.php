<?php namespace Lio\Forum\Threads;

class Thread extends \Lio\Core\Entity
{
    protected $table      = 'forum_threads';
    protected $fillable   = ['subject', 'body', 'author_id', 'category_slug', 'laravel_version'];
    protected $with       = ['author'];
    protected $softDelete = true;

    public $presenter = 'Lio\Forum\Threads\ThreadPresenter';

    protected $validationRules = [
        'body'      => 'required',
        'author_id' => 'required|exists:users,id',
    ];

    protected $laravelVersions = [
        0 => "Doesn't Matter",
        3 => "Laravel 3.x",
        4 => "Laravel 4.x",
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function replies()
    {
        return $this->hasMany('Lio\Forum\Replies\Reply', 'thread_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Tags\Tag', 'comment_tag', 'comment_id', 'tag_id');
    }

    public function mostRecentReply()
    {
        return $this->belongsTo('Lio\Forum\Replies\Reply', 'most_recent_reply_id');
    }

    public function setSubjectAttribute($subject)
    {
        $this->attributes['subject'] = $subject;

        if ($this->created_at) {
            $date = date('m-d-Y', strtotime($this->created_at));
        } else {
            $date = date('m-d-Y');
        }

        $this->attributes['slug'] = \Str::slug("{$date} - {$this->subject}");
    }

    public function getLaravelVersions()
    {
        return $this->laravelVersions;
    }

    public function isOwnedBy(\Lio\Accounts\User $user)
    {
        return $user->id == $this->author_id;
    }

    public function setMostRecentReply(Reply $reply)
    {
        $this->most_recent_reply_id = $reply->id;
        $this->updateReplyCount();
        $this->save();
    }

    public function updateReplyCount()
    {
        if ($this->exists) {
            $this->reply_count = $this->replies()->count();
            $this->save();
        }
    }

    public function setTags(array $tagIds)
    {
        $this->tags()->sync($tagIds);
    }

    public function hasTag($tagId)
    {
        return $this->tags->contains($tagId);
    }

    public function getTags()
    {
        return $this->tags->lists('slug');
    }

    public function isNewerThan($timestamp)
    {
        return strtotime($this->updated_at) > $timestamp;
    }
}