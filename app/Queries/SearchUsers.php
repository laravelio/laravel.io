<?php

namespace App\Queries;

use App\User;
use Illuminate\Contracts\Pagination\Paginator;

class SearchUsers
{
    /**
     * @return \App\User[]
     */
    public static function get(string $keyword, int $perPage = 20): Paginator
    {
        return User::where(function ($query) use ($keyword) {
            $query->where('name', 'like', $keyword.'%')
                ->orWhere('email', 'like', $keyword.'%')
                ->orWhere('username', 'like', $keyword.'%');
        })->paginate($perPage);
    }
}
