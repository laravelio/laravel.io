<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function show(Topic $topic)
    {
        return view('forum.overview', ['threads' => $topic->paginatedThreads(), 'activeTopic' => $topic]);
    }
}
