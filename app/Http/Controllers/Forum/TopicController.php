<?php

namespace Lio\Http\Controllers\Forum;

use Lio\Forum\Topics\Topic;
use Lio\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        return view('forum.overview', compact('topic'));
    }
}
