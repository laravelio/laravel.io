<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        $threads = $topic->paginatedThreads();

        return view('forum.overview', [
            'activeTopic' => $topic,
            'threads' => $threads,
            'topics' => Topic::all(),
        ]);
    }
}
