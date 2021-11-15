<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUpdatedBy
{
    public function updatedByRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function updatedBy(): ?User
    {
        return $this->updatedByRelation;
    }
}
