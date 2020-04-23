<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasLikes;
use App\Helpers\HasSlug;
use App\Helpers\HasTags;
use App\Helpers\HasTimestamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Article extends Model
{
    use HasAuthor, HasSlug, HasLikes, HasTimestamps, HasTags;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'body',
        'original_url',
        'slug',
        'published_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'published_at',
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

    public function isPublished(): bool
    {
        return ! $this->isNotPublished();
    }

    public function isNotPublished(): bool
    {
        return is_null($this->published_at);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->whereNull('published_at');
    }
}
