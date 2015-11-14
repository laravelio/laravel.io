<?php
namespace Lio\Replies;

use Illuminate\Database\Eloquent\Model;
use Lio\Eloquent\HasTimestamps;
use Lio\Users\EloquentUser;

final class EloquentReply extends Model implements Reply
{
    use HasTimestamps;

    /**
     * @var string
     */
    protected $table = 'replies';

    /**
     * @var array
     */
    protected $fillable = ['body'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return \Lio\Replies\ReplyAble
     */
    public function replyAble()
    {
        return $this->replyAbleRelation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function replyAbleRelation()
    {
        return $this->morphTo('replyable');
    }

    /**
     * @return \Lio\Users\User
     */
    public function author()
    {
        return $this->authorRelation;
    }

    /**
     * @return \Lio\Users\User
     */
    public function authorRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'author_id');
    }
}
