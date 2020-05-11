<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyArticles extends Controller
{
    public function __invoke(Request $request)
    {
        return view('users.articles', [
            'articles' => $request->user()
                ->articles()
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->paginate(10)
        ]);
    }
}
