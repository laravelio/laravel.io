<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasLikes;
use App\Helpers\HasTimestamps;
use App\Helpers\ModelHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

final class Reply extends Model
{
    use HasAuthor;
    use HasLikes;
    use HasTimestamps;
    use ModelHelpers;

    const TABLE = 'replies';

    /**
     * {@inheritdoc}
     */
    protected $table = self::TABLE;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'body',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = ['likes'];

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
        return Str::limit(strip_tags(md_to_html($this->body())), $limit);
    }

    public function to(ReplyAble $replyAble)
    {
        $this->replyAbleRelation()->associate($replyAble);
    }

    public function replyAble(): ReplyAble
    {
        return $this->replyAbleRelation;
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function replyAbleRelation(): MorphTo
    {
        return $this->morphTo('replyAbleRelation', 'replyable_type', 'replyable_id');
    }
}
