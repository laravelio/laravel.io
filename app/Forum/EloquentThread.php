<?php

namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lio\DateTime\HasTimestamps;
use Lio\Forum\Topics\EloquentTopic;
use Lio\Forum\Topics\Topic;
use Lio\Replies\UsesReplies;
use Lio\Replies\ReplyAble;
use Lio\Tags\UsesTags;
use Lio\Users\HasAuthor;

final class EloquentThread extends Model implements Thread, ReplyAble
{
    use HasAuthor, HasTimestamps, UsesReplies, UsesTags;

    /**
     * @var string
     */
    protected $table = self::TYPE;

    /**
     * @var string
     */
    protected $morphClass = self::TYPE;

    /**
     * @var array
     */
    protected $fillable = ['subject', 'body'];

    public function id(): int
    {
        return $this->id;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function topic(): Topic
    {
        return $this->topicRelation;
    }

    public function topicRelation(): BelongsTo
    {
        return $this->belongsTo(EloquentTopic::class, 'topic_id');
    }
}
