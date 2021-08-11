<?php

namespace App\Queries;

use App\Models\Article;
use Illuminate\Contracts\Pagination\Paginator;

final class SearchArticles
{
    /**
     * @return \App\Models\Article[]
     */
    public static function get(string $keyword, int $perPage = 20): Paginator
    {
        return Article::where('title', 'like', "%$keyword%")
            ->orWhere('body', 'like', "%$keyword%")
            ->orWhere('slug', 'like', "%$keyword%")
            ->orderByDesc('submitted_at')
            ->paginate($perPage);
    }
}
