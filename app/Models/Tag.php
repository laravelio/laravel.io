<?php

namespace App\Models;

use App\Helpers\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasSlug;

    /**
     * {@inheritdoc}
     */
    protected $table = 'tags';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

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

    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return \App\Models\Thread[]
     */
    public function threads()
    {
        return $this->threadsRelation;
    }

    public function threadsRelation(): MorphToMany
    {
        return $this->morphedByMany(Thread::class, 'taggable', 'taggables', 'tag_id');
    }
}
