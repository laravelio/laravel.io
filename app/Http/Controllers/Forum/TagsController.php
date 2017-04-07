<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        return view('forum.overview', ['threads' => $tag->paginatedThreads(), 'activeTag' => $tag]);
    }
}
