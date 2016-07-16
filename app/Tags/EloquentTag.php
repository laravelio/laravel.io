<?php

namespace Lio\Tags;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Lio\Forum\EloquentThread;

final class EloquentTag extends Model implements Tag
{
    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
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
     * @return \Lio\Forum\Thread[]
     */
    public function threads()
    {
        return $this->threadsRelation;
    }

    public function threadsRelation(): MorphToMany
    {
        return $this->morphedByMany(EloquentThread::class, 'taggable', 'taggables', 'tag_id');
    }
}
