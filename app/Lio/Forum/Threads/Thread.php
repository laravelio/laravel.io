<?php namespace Lio\Forum\Threads;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Lio\Core\Entity;
use Lio\Forum\Replies\Reply;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Thread extends Entity implements PresenterInterface
{
    use SoftDeletingTrait;

    protected $table    = 'forum_threads';
    protected $fillable = ['subject', 'body', 'author_id', 'is_question', 'solution_reply_id', 'category_slug', 'laravel_version'];
    protected $dates    = ['deleted_at'];

    protected $validationRules = [
        'body'      => 'required',
        'author_id' => 'required|exists:users,id',
    ];

    protected $laravelVersions = [
        4 => "Laravel 4.x",
        3 => "Laravel 3.x",
        0 => "Doesn't Matter",
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function replies()
    {
        return $this->hasMany('Lio\Forum\Replies\Reply', 'thread_id');
    }

    public function acceptedSolution()
    {
        return $this->belongsTo('Lio\Forum\Replies\Reply', 'solution_reply_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Tags\Tag', 'tagged_items', 'thread_id', 'tag_id');
    }

    public function mostRecentReply()
    {
        return $this->belongsTo('Lio\Forum\Replies\Reply', 'most_recent_reply_id');
    }

    public function setSubjectAttribute($subject)
    {
        $this->attributes['subject'] = $subject;
        $this->attributes['slug'] = $this->generateNewSlug();
    }

    public function scopeSolvedQuestions($q)
    {
        return $q->where('is_question', '=', 1)->whereNull('solution_reply_id');
    }

    public function scopeUnsolvedQuestions($q)
    {
        return $q->where('is_question', '=', 1)->whereNotNull('solution_reply_id');
    }

    private function generateNewSlug()
    {
        $i = 0;

        while ($this->getCountBySlug($this->generateSlugByIncrementer($i)) > 0) {
            $i++;
        }

        return $this->generateSlugByIncrementer($i);
    }

    private function getCountBySlug($slug)
    {
        $query = static::where('slug', '=', $slug);

        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        return $query->count();
    }

    private function generateSlugByIncrementer($i)
    {
        if ($i == 0) $i = '';

        if ($this->created_at) {
            $date = date('m-d-Y', strtotime($this->created_at));
        } else {
            $date = date('m-d-Y');
        }

        return \Str::slug("{$date} - {$this->subject}" . $i);
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

    public function isManageableBy($user)
    {
        if ( ! $user) return false;
        return $this->isOwnedBy($user) || $user->isForumAdmin();
    }

    public function isOwnedBy($user)
    {
        if ( ! $user) return false;
        return $user->id == $this->author_id;
    }

    public function isReplyTheSolution($reply)
    {
        return $reply->id == $this->solution_reply_id;
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

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Lio\Forum\Threads\ThreadPresenter';
    }
}
