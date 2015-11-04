<?php
namespace Lio\Replies;

use Illuminate\Database\Eloquent\Model;
use Lio\Users\EloquentUser;

final class EloquentReply extends Model implements Reply
{
    /**
     * @var string
     */
    protected $table = 'replies';

    /**
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function replyable()
    {
        return $this->morphTo();
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
