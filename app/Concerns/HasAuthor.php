<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author(): User
    {
        return $this->authorRelation;
    }

    public function authoredBy(User $author)
    {
        $this->authorRelation()->associate($author);

        $this->unsetRelation('authorRelation');
    }

    public function authorRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author()->is($user);
    }
}
