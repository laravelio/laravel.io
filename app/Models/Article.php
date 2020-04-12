<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasLikes;
use App\Helpers\HasSlug;
use App\Helpers\HasTags;
use App\Helpers\HasTimestamps;
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
        'slug',
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

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
