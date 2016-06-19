<?php

namespace Lio\Users;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author(): User
    {
        return $this->authorRelation;
    }

    public function authorRelation(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'author_id');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author()->id() === $user->id();
    }
}
