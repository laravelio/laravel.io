<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\ModelHelpers;
use App\Helpers\HasTimestamps;
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

    public function excerpt(int $limit = 100): string
    {
        return str_limit(strip_tags(md_to_html($this->body())), $limit);
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
