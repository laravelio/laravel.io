<?php

namespace App\Concerns;

use Carbon\Carbon;

trait HasTimestamps
{
    public function createdAt(): Carbon
    {
        return $this->created_at;
    }

    public function updatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
