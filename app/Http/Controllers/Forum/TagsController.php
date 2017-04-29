<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Thread;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        return view('forum.overview', ['threads' => Thread::latestByTagPaginated($tag), 'activeTag' => $tag]);
    }
}
