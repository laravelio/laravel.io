<?php

namespace App\Helpers;

use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author(): User
    {
        return $this->authorRelation;
    }

    public function authorRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author()->id() === $user->id();
    }

    public static function deleteByAuthor(User $author)
    {
        static::where('author_id', $author->id())->delete();
    }
}
