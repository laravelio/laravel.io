<?php

namespace App\Queries;

use App\Models\Thread;
use Illuminate\Contracts\Pagination\Paginator;

final class SearchThreads
{
    /**
     * @return \App\Models\Thread[]
     */
    public static function get(string $keyword, int $perPage = 20): Paginator
    {
        return Thread::where('subject', 'like', "%$keyword%")
            ->orWhere('body', 'like', "%$keyword%")
            ->orWhere('slug', 'like', "%$keyword%")
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }
}
