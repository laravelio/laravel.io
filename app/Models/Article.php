<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasLikes;
use App\Helpers\HasSlug;
use App\Helpers\HasTags;
use App\Helpers\HasTimestamps;
use App\Helpers\PreparesSearch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

final class Article extends Model
{
    use HasAuthor;
    use HasSlug;
    use HasLikes;
    use HasTimestamps;
    use HasTags;
    use PreparesSearch;
    use Searchable;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'body',
        'original_url',
        'slug',
        'published_at',
        'approved_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'published_at',
        'approved_at',
    ];

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

    public function originalUrl(): ?string
    {
        return $this->original_url;
    }

    public function canonicalUrl(): string
    {
        return $this->originalUrl() ?: route('articles.show', $this->slug);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function updateSeries(Series $series = null): self
    {
        if (is_null($series)) {
            return $this->removeSeries();
        }

        return $this->addToSeries($series);
    }

    public function addToSeries(Series $series): self
    {
        $this->series()->associate($series);
        $this->save();

        return $this;
    }

    public function removeSeries(): self
    {
        $this->series()->dissociate();
        $this->save();

        return $this;
    }

    public function publishedAt(): ?Carbon
    {
        return $this->published_at;
    }

    public function approvedAt(): ?Carbon
    {
        return $this->approved_at;
    }

    public function isPublished(): bool
    {
        return ! $this->isNotPublished();
    }

    public function isNotPublished(): bool
    {
        return is_null($this->published_at) || is_null($this->approved_at);
    }

    public function isAwaitingApproval(): bool
    {
        return ! is_null($this->published_at) && is_null($this->approved_at);
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

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->whereNotNull('approved_at');
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhereNull('approved_at');
        });
    }

    public function scopeForTag(Builder $query, string $tag): Builder
    {
        return $query->whereHas('tagsRelation', function ($query) use ($tag) {
            $query->where('tags.slug', $tag);
        });
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->orderBy('published_at', 'desc');
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->withCount(['likes' => function ($query) {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('likes_count', 'desc')
            ->orderBy('published_at', 'desc');
    }

    public function previousInSeries(): ?Article
    {
        return $this->series
            ->articles()
            ->published()
            ->where('published_at', '<', $this->publishedAt())
            ->orderByDesc('published_at')
            ->first();
    }

    public function nextInSeries(): ?Article
    {
        return $this->series
            ->articles()
            ->published()
            ->where('published_at', '>', $this->publishedAt())
            ->orderBy('published_at')
            ->first();
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
}
