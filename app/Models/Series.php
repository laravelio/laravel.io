<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasSlug;
use App\Concerns\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    use HasAuthor;
    use HasTags;
    use HasSlug;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
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

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
