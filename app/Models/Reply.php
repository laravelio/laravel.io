<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasTimestamps;
use App\Helpers\ModelHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reply extends Model
{
    use HasAuthor, HasTimestamps, ModelHelpers;

    /**
     * {@inheritdoc}
     */
    protected $table = 'replies';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['body', 'ip'];

    public function id(): int
    {
        return $this->id;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function to(ReplyAble $replyAble)
    {
        $this->replyAbleRelation()->associate($replyAble);
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
