<?php

namespace App\Helpers;

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
