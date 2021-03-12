<?php

namespace App\Http\Controllers\Forum;

use App\Helpers\UsesFilters;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

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
                ->paginate(20);
        }

        if ($filter === 'active') {
            $threads = Thread::feedByTagQuery($tag)
                ->active()
                ->paginate(20);
        }

        $tags = Tag::orderBy('name')->get();
        $mostSolutions = Cache::remember('mostSolutions', now()->addDay(), function() {
            return User::mostSolutions()->take(5)->get();
        });

        return view('forum.overview', compact('threads', 'filter', 'tags', 'mostSolutions') + ['activeTag' => $tag]);
    }
}
