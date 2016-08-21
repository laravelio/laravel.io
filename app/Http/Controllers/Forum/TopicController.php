<?php

namespace App\Http\Controllers\Forum;

use App\Forum\Topics\Topic;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        return view('forum.overview', compact('topic'));
    }
}
