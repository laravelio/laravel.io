<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        $threads = $tag->paginatedThreads();

        return view('forum.overview', ['threads' => $threads, 'activeTag' => $tag]);
    }
}
