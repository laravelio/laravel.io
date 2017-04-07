<?php

namespace App\Models;

use App\Helpers\HasSlug;
use App\Helpers\ModelHelpers;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasSlug, ModelHelpers;

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

    public function paginatedThreads(int $perPage = 10): LengthAwarePaginator
    {
        return $this->threadsRelation()->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function threadsRelation(): MorphToMany
    {
        return $this->morphedByMany(Thread::class, 'taggable', 'taggables', 'tag_id');
    }
}
