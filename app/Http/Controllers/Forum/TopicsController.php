<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function show(Topic $topic)
    {
        $threads = $topic->paginatedThreads();

        return view('forum.overview', ['threads' => $threads, 'activeTopic' => $topic]);
    }
}
