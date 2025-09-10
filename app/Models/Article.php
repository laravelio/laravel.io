<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasLikes;
use App\Concerns\HasSlug;
use App\Concerns\HasTags;
use App\Concerns\HasTimestamps;
use App\Concerns\HasUuid;
use App\Concerns\PreparesSearch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

final class Article extends Model implements Feedable
{
    use HasAuthor;
    use HasFactory;
    use HasLikes;
    use HasSlug;
    use HasTags;
    use HasTimestamps;
    use HasUuid;
    use PreparesSearch;
    use Searchable;

    const TABLE = 'articles';

    const FEED_PAGE_SIZE = 20;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'uuid',
        'title',
        'body',
        'original_url',
        'slug',
        'hero_image_id',
        'hero_image_url',
        'hero_image_author_name',
        'hero_image_author_url',
        'is_pinned',
        'view_count',
        'tweet_id',
        'submitted_at',
        'approved_at',
        'declined_at',
        'shared_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'authorRelation',
        'likesRelation',
        'likersRelation',
        'tagsRelation',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'shared_at' => 'datetime',
            'is_pinned' => 'boolean',
            'is_sponsored' => 'boolean',
        ];
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags(md_to_html($this->body())), $limit);
    }

    public function hasHeroImageAuthor(): bool
    {
        return $this->hero_image_author_name !== null &&
            $this->hero_image_author_url !== null;
    }

    public function heroImage($width = 400, $height = 300): string
    {
        return "{$this->hero_image_url}&fit=clip&w={$width}&h={$height}&utm_source=Laravel.io&utm_medium=referral";
    }

    public function originalUrl(): ?string
    {
        return $this->original_url;
    }

    public function canonicalUrl(): string
    {
        return $this->originalUrl() ?: route('articles.show', $this->slug);
    }

    public function submittedAt(): ?Carbon
    {
        return $this->submitted_at;
    }

    public function approvedAt(): ?Carbon
    {
        return $this->approved_at;
    }

    public function isSubmitted(): bool
    {
        return ! $this->isNotSubmitted();
    }

    public function isNotSubmitted(): bool
    {
        return $this->submitted_at === null;
    }

    public function isApproved(): bool
    {
        return ! $this->isNotApproved();
    }

    public function isNotApproved(): bool
    {
        return $this->approved_at === null;
    }

    public function isDeclined(): bool
    {
        return ! $this->isNotDeclined();
    }

    public function isNotDeclined(): bool
    {
        return $this->declined_at === null;
    }

    public function isPublished(): bool
    {
        return ! $this->isNotPublished();
    }

    public function isNotPublished(): bool
    {
        return $this->isNotSubmitted() || $this->isNotApproved() || $this->isDeclined();
    }

    public function isPinned(): bool
    {
        return (bool) $this->is_pinned;
    }

    public function isSponsored(): bool
    {
        return (bool) $this->is_sponsored;
    }

    public function isNotShared(): bool
    {
        return $this->shared_at === null;
    }

    public function isShared(): bool
    {
        return ! $this->isNotShared();
    }

    public function isAwaitingApproval(): bool
    {
        return $this->isSubmitted() && $this->isNotApproved() && $this->isNotDeclined();
    }

    public function isNotAwaitingApproval(): bool
    {
        return ! $this->isAwaitingApproval();
    }

    public function readTime()
    {
        $minutes = round(str_word_count($this->body()) / 200);

        return $minutes == 0 ? 1 : $minutes;
    }

    public function viewCount()
    {
        return number_format($this->view_count);
    }

    public function isUpdated(): bool
    {
        return $this->updated_at->gt($this->created_at);
    }

    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->whereNotNull('submitted_at');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_at')->whereNull('declined_at');
    }

    public function scopeNotApproved(Builder $query): Builder
    {
        return $query->whereNull('approved_at');
    }

    public function scopeDeclined(Builder $query): Builder
    {
        return $query->whereNotNull('declined_at');
    }

    public function scopeNotDeclined(Builder $query): Builder
    {
        return $query->whereNull('declined_at');
    }

    public function scopeAwaitingApproval(Builder $query): Builder
    {
        return $query->submitted()
            ->notApproved()
            ->notDeclined();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->submitted()
            ->approved();
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereNull('submitted_at')
                ->orWhereNull('approved_at')
                ->orWhereNotNull('declined_at');
        });
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeShared(Builder $query): Builder
    {
        return $query->whereNotNull('shared_at');
    }

    public function scopeNotShared(Builder $query): Builder
    {
        return $query->whereNull('shared_at');
    }

    public function scopeForTag(Builder $query, string $tag): Builder
    {
        return $query->whereHas('tagsRelation', function ($query) use ($tag) {
            $query->where('tags.slug', $tag);
        });
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('submitted_at', 'desc');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('likesRelation')
            ->orderBy('likes_relation_count', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->withCount(['likesRelation' => function ($query) {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('likes_relation_count', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function scopeUnsyncedImages(Builder $query): Builder
    {
        return $query->whereNotNull('hero_image_id')
            ->whereNull('hero_image_url');
    }

    public function shouldBeSearchable()
    {
        return $this->isPublished();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id(),
            'title' => $this->title(),
            'body' => $this->body(),
            'slug' => $this->slug(),
        ];
    }

    public function splitBody($value)
    {
        return $this->split($value);
    }

    public function markAsShared()
    {
        $this->update([
            'shared_at' => now(),
        ]);
    }

    public static function nextForSharing(): ?self
    {
        return self::notShared()
            ->published()
            ->orderBy('submitted_at', 'asc')
            ->first();
    }

    public static function getFeedItems(): Collection
    {
        return self::published()
            ->recent()
            ->paginate(self::FEED_PAGE_SIZE)
            ->getCollection();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id())
            ->title($this->title())
            ->summary($this->excerpt())
            ->updated($this->updatedAt())
            ->link(route('articles.show', $this->slug()))
            ->authorName($this->author()->name());
    }
}
