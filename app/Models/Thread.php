<?php

namespace App\Models;

use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Helpers\HasAuthor;
use App\Helpers\HasLikes;
use App\Helpers\HasSlug;
use App\Helpers\HasTags;
use App\Helpers\HasTimestamps;
use App\Helpers\ModelHelpers;
use App\Helpers\PreparesSearch;
use App\Helpers\ProvidesSubscriptions;
use App\Helpers\ReceivesReplies;
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

final class Thread extends Model implements ReplyAble, SubscriptionAble, Feedable
{
    use HasFactory;
    use HasAuthor;
    use HasLikes;
    use HasSlug;
    use HasTags;
    use HasTimestamps;
    use ModelHelpers;
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
        return ! is_null($this->solution_reply_id);
    }

    public function isSolutionReply(Reply $reply): bool
    {
        if ($solution = $this->solutionReply()) {
            return $solution->matches($reply);
        }

        return false;
    }

    public function markSolution(Reply $reply)
    {
        $thread = $reply->replyAble();

        if (! $thread instanceof self) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $this->solutionReplyRelation()->associate($reply);
        $this->save();
    }

    public function unmarkSolution()
    {
        $this->solutionReplyRelation()->dissociate();
        $this->save();
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
        return static::feedQuery()->limit($limit)->get();
    }

    /**
     * @return \App\Models\Thread[]
     */
    public static function feedPaginated(int $perPage = 20): Paginator
    {
        return static::feedQuery()->paginate($perPage);
    }

    /**
     * @return \App\Models\Thread[]
     */
    public static function feedByTagPaginated(Tag $tag, int $perPage = 20): Paginator
    {
        return static::feedQuery()
            ->join('taggables', function ($join) {
                $join->on('threads.id', 'taggables.taggable_id')
                    ->where('taggable_type', static::TABLE);
            })
            ->where('taggables.tag_id', $tag->id())
            ->paginate($perPage);
    }

    /**
     * This will order the threads by creation date and latest reply.
     */
    public static function feedQuery(): Builder
    {
        return static::with([
            'solutionReplyRelation',
            'repliesRelation',
            'repliesRelation.authorRelation',
            'tagsRelation',
            'authorRelation',
        ])
            ->leftJoin('replies', function ($join) {
                $join->on('threads.id', 'replies.replyable_id')
                    ->where('replies.replyable_type', static::TABLE);
            })
            ->orderBy('latest_creation', 'DESC')
            ->groupBy('threads.id')
            ->select('threads.*', DB::raw('
                CASE WHEN COALESCE(MAX(replies.created_at), 0) > threads.created_at
                THEN COALESCE(MAX(replies.created_at), 0)
                ELSE threads.created_at
                END AS latest_creation
            '));
    }

    /**
     * This will calculate the average resolution time in days of all threads marked as resolved.
     */
    public static function resolutionTime()
    {
        try {
            return static::join('replies', 'threads.solution_reply_id', '=', 'replies.id')
                ->select(DB::raw('avg(datediff(replies.created_at, threads.created_at)) as duration'))
                ->first()
                ->duration;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getFeedItems(): SupportCollection
    {
        return static::feedQuery()
            ->paginate(static::FEED_PAGE_SIZE)
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

    public function splitBody($value)
    {
        return $this->split($value);
    }
}
