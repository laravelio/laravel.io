<?php

namespace App\Queries;

use App\Models\Reply;
use Illuminate\Contracts\Pagination\Paginator;

final class SearchReplies
{
    /**
     * @return \App\Models\Reply[]
     */
    public static function get(string $keyword, int $perPage = 20): Paginator
    {
        return Reply::with('replyAbleRelation')
            ->where('body', 'like', "%$keyword%")
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }
}
