<?php

namespace App\Http\Controllers\Forum;

use App\Concerns\UsesFilters;
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
                ->paginate(20);
        }

        if ($filter === 'unresolved') {
            $threads = Thread::feedByTagQuery($tag)
                ->unresolved()
                ->paginate(20);
        }

        $tags = Tag::orderBy('name')->get();
        $topMembers = User::mostSolutionsInLastDays(365)->take(5)->get();
        $moderators = User::moderators()->get();
        $canonical = canonical('forum.tag', [$tag->name, 'filter' => $filter]);

        return view('forum.overview', compact('threads', 'filter', 'tags', 'topMembers', 'moderators', 'canonical') + ['activeTag' => $tag]);
    }
}
