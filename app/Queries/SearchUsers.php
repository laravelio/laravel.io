<?php

namespace App\Queries;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

final class SearchUsers
{
    /**
     * @return \App\Models\User[]
     */
    public static function get(string $keyword, int $perPage = 20): Paginator
    {
        return User::where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('username', 'like', "%$keyword%")
            ->paginate($perPage);
    }
}
