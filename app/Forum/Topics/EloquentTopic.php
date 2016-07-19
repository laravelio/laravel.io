<?php

namespace Lio\Forum\Topics;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lio\DateTime\HasTimestamps;
use Lio\Forum\EloquentThread;

final class EloquentTopic extends Model implements Topic
{
    use HasTimestamps;

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

    public function slug(): string
    {
        return $this->slug;
    }

    /**
     * @return \Lio\Forum\Threads[]
     */
    public function threads()
    {
        return $this->threadsRelation;
    }

    public function paginatedThreads(int $perPage = 10): LengthAwarePaginator
    {
        return $this->threadsRelation()->paginate($perPage);
    }

    public function threadsRelation(): HasMany
    {
        return $this->hasMany(EloquentThread::class, 'topic_id');
    }
}
