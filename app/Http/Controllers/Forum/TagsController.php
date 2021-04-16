<?php

namespace App\Http\Controllers\Forum;

use App\Helpers\UsesFilters;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;

class TagsController extends Controller
{
    use UsesFilters;

    public function show(Tag $tag)
    {
        $threads = [];
        $filter = $this->getFilter();

        if ($filter === 'recent') {
            $threads = Thread::feedByTagPaginated($tag);
        }

        if ($filter === 'resolved') {
            $threads = Thread::feedByTagQuery($tag)
                ->resolved()
                ->paginate(config('lio.pagination.count'));
        }

        if ($filter === 'active') {
            $threads = Thread::feedByTagQuery($tag)
                ->active()
                ->paginate(config('lio.pagination.count'));
        }

        $tags = Tag::orderBy('name')->get();
        $mostSolutions = User::mostSolutions()->take(5)->get();

        return view('forum.overview', compact('threads', 'filter', 'tags', 'mostSolutions') + ['activeTag' => $tag]);
    }
}
