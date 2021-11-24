<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasLikes;
use App\Concerns\HasSlug;
use App\Concerns\HasTags;
use App\Concerns\HasTimestamps;
use App\Concerns\PreparesSearch;
use App\Concerns\ProvidesSubscriptions;
use App\Concerns\ReceivesReplies;
use App\Exceptions\CouldNotMarkReplyAsSolution;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

final class Thread extends Model implements Feedable, ReplyAble, SubscriptionAble
{
    use HasFactory;
    use HasAuthor;
    use HasLikes;
    use HasSlug;
    use HasTags;
    use HasTimestamps;
    use PreparesSearch;
    use ProvidesSubscriptions;
    use ReceivesReplies;
    use Searchable;

    const TABLE = 'threads';

    const FEED_PAGE_SIZE = 20;

    /**
     * {@inheritdoc}
     */
    protected $table = self::TABLE;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'body',
        'slug',
        'subject',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'authorRelation',
        'likesRelation',
        'repliesRelation',
        'tagsRelation',
        'updatedByRelation',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

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

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags(md_to_html($this->body())), $limit);
    }

    public function updatedBy(): ?User
    {
        return $this->updatedByRelation;
    }

    public function updatedByRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function isUpdated(): bool
    {
        return $this->updated_at->gt($this->created_at);
    }

    public function solutionReply(): ?Reply
    {
        return $this->solutionReplyRelation;
    }

    public function solutionReplyRelation(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'solution_reply_id');
    }

    public function isSolved(): bool
    {
        return null !== $this->solution_reply_id;
    }

    public function isSolutionReply(Reply $reply): bool
    {
        if ($solution = $this->solutionReply()) {
            return $solution->is($reply);
        }

        return false;
    }

    public function markSolution(Reply $reply, User $user)
    {
        $thread = $reply->replyAble();

        if (! $thread instanceof self) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $this->resolvedByRelation()->associate($user);
        $this->solutionReplyRelation()->associate($reply);
        $this->save();
    }

    public function unmarkSolution()
    {
        $this->resolvedByRelation()->dissociate();
        $this->solutionReplyRelation()->dissociate();
        $this->save();
    }

    public function resolvedBy(): ?User
    {
        return $this->resolvedByRelation;
    }

    public function resolvedByRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function wasResolvedBy(User $user): bool
    {
        if ($resolvedBy = $this->resolvedBy()) {
            return $resolvedBy->is($user);
        }

        return false;
    }

    public function delete()
    {
        $this->removeTags();
        $this->deleteReplies();

        parent::delete();
    }

    public function toFeedItem(): FeedItem
    {
        $updatedAt = Carbon::parse($this->latest_creation);

        return FeedItem::create()
            ->id($this->id)
            ->title($this->subject)
            ->summary($this->body)
            ->updated($updatedAt)
            ->link(route('thread', $this->slug))
            ->author($this->author()->name);
    }

    /**
     * @return \App\Models\Thread[]
     */
    public static function feed(int $limit = 20): Collection
    {
        return self::feedQuery()->limit($limit)->get();
    }

    /**
     * @return \App\Models\Thread[]
     */
    public static function feedPaginated(int $perPage = 20): Paginator
    {
        return self::feedQuery()->paginate($perPage);
    }

    /**
     * @return \App\Models\Thread[]
     */
    public static function feedByTagPaginated(Tag $tag, int $perPage = 20): Paginator
    {
        return self::feedByTagQuery($tag)
            ->paginate($perPage);
    }

    public static function feedByTagQuery(Tag $tag): Builder
    {
        return self::feedQuery()
            ->join('taggables', function ($join) {
                $join->on('threads.id', 'taggables.taggable_id')
                    ->where('taggable_type', static::TABLE);
            })
            ->where('taggables.tag_id', $tag->id());
    }

    /**
     * This will order the threads by creation date and latest reply.
     */
    public static function feedQuery(): Builder
    {
        return self::withOnly([
            'tagsRelation',
            'authorRelation',
        ])
            ->withCount(['repliesRelation as reply_count', 'likesRelation as like_count'])
            ->latest('last_activity_at');
    }

    /**
     * This will calculate the average resolution time in days of all threads marked as resolved.
     */
    public static function resolutionTime()
    {
        try {
            return self::join('replies', 'threads.solution_reply_id', '=', 'replies.id')
                ->select(DB::raw('avg(datediff(replies.created_at, threads.created_at)) as duration'))
                ->first()
                ->duration;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getFeedItems(): SupportCollection
    {
        return self::feedQuery()
            ->paginate(self::FEED_PAGE_SIZE)
            ->getCollection();
    }

    public function replyAbleSubject(): string
    {
        return $this->subject();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id(),
            'subject' => $this->subject(),
            'body' => $this->body(),
            'slug' => $this->slug(),
        ];
    }

    public function searchIndexShouldBeUpdated()
    {
        return $this->isDirty([
            'subject',
            'body',
            'slug',
        ]);
    }

    public function splitBody($value)
    {
        return $this->split($value);
    }

    public function scopeResolved(Builder $query): Builder
    {
        return $query->whereNotNull('solution_reply_id');
    }

    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->whereNull('solution_reply_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->has('repliesRelation');
    }
}
