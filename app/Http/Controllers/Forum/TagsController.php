<?php

namespace App\Http\Controllers\Forum;

use App\Models\Tag;
use App\Models\Thread;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        return view('forum.overview', ['threads' => Thread::feedByTagPaginated($tag), 'activeTag' => $tag]);
    }
}
