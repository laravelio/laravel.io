<?php

namespace App\Replies;

use App\DateTime\Timestamps;
use App\Users\Authored;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\DateTime\HasTimestamps;
use App\Users\HasAuthor;

class Reply extends Model implements Authored, Timestamps
{
    use HasAuthor, HasTimestamps;

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
}
