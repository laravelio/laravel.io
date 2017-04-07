<?php

namespace App\Models;

use App\Helpers\HasTimestamps;
use App\Helpers\HasSlug;
use App\Helpers\ModelHelpers;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasSlug, HasTimestamps, ModelHelpers;

    /**
     * @var string
     */
    protected $table = 'topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return \App\Models\Threads[]
     */
    public function threads()
    {
        return $this->threadsRelation;
    }

    public function paginatedThreads(int $perPage = 10): LengthAwarePaginator
    {
        return $this->threadsRelation()->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function threadsRelation(): HasMany
    {
        return $this->hasMany(Thread::class, 'topic_id');
    }
}
