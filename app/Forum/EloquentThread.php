<?php

namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\DateTime\HasTimestamps;
use Lio\Replies\UsesReplies;
use Lio\Replies\ReplyAble;
use Lio\Users\HasAuthor;

final class EloquentThread extends Model implements Thread, ReplyAble
{
    use HasAuthor, HasTimestamps, UsesReplies;

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
}
