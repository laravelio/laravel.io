<?php

namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;
use Lio\Eloquent\HasTimestamps;
use Lio\Replies\MorphManyReplies;
use Lio\Replies\ReplyAble;

final class EloquentThread extends Model implements Thread, ReplyAble
{
    use HasTimestamps, MorphManyReplies;

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
