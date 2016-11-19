<?php

namespace App\Http\Controllers;

use App\Forum\Topic;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        return view('forum.overview', compact('topic'));
    }
}
