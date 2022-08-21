<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasLikes;
use App\Concerns\HasMentions;
use App\Concerns\HasTimestamps;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

final class Reply extends Model implements MentionAble
{
    use HasAuthor;
    use HasFactory;
    use HasLikes;
    use HasMentions;
    use HasTimestamps;
    use HasUuid;
    use SoftDeletes;

    const TABLE = 'replies';

    /**
     * @inheritdoc
     */
    protected $table = self::TABLE;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'uuid',
        'body',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * @inheritdoc
     */
    protected $with = [
        'likesRelation',
        'updatedByRelation',
    ];

    public function solutionTo(): HasOne
    {
        return $this->hasOne(Thread::class, 'solution_reply_id');
    }

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

    public function updatedBy(): ?User
    {
        return $this->updatedByRelation;
    }

    public function deletedBy(): ?User
    {
        return $this->deletedByRelation;
    }

    public function updatedByRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedByRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function isDeletedBy(User $user): bool
    {
        return $user->is($this->deletedBy());
    }

    public function isUpdated(): bool
    {
        return $this->updated_at->gt($this->created_at);
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

    public function scopeIsSolution(Builder $builder): Builder
    {
        return $builder->has('solutionTo');
    }
}
