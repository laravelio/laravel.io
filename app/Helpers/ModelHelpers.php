<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\Paginator;

trait ModelHelpers
{
    public static function findAllPaginated(int $perPage = 20): Paginator
    {
        return static::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function matches(self $model): bool
    {
        return $this->id === $model->id();
    }
}
