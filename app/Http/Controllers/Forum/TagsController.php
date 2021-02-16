<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        $filter = (string) request('filter') ?: 'recent';

        if ($filter === 'recent') {
            $threads = Thread::feedByTagPaginated($tag);
        }

        if ($filter === 'resolved') {
            $threads = Thread::feedByTagQuery($tag)
                ->resolved()
                ->get();
        }

        if ($filter === 'active') {
            $threads = Thread::feedByTagQuery($tag)
                ->active()
                ->get();
        }

        $mostSolutions = User::mostSolutions()->take(3)->get();

        return view('forum.overview', compact('threads', 'filter', 'mostSolutions') + ['activeTag' => $tag]);
    }
}
