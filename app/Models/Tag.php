<?php

namespace App\Models;

use App\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class Tag extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * {@inheritdoc}
     */
    protected $table = 'tags';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    private array $specialTags = [
        'Laravel.io',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function isSpecial(): bool
    {
        return in_array($this->name(), $this->specialTags);
    }
}
