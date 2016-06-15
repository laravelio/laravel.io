<?php

namespace Lio\Replies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Lio\Eloquent\HasTimestamps;
use Lio\Users\EloquentUser;
use Lio\Users\User;

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

    public function id(): int
    {
        return $this->id;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function replyAble(): ReplyAble
    {
        return $this->replyAbleRelation;
    }

    public function replyAbleRelation(): MorphTo
    {
        return $this->morphTo('replyable');
    }

    public function author(): User
    {
        return $this->authorRelation;
    }

    public function authorRelation(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'author_id');
    }
}
