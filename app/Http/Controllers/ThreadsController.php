<?php

namespace App\Http\Controllers;

use App\Jobs\CreateThread;
use App\Jobs\MarkThreadSolution;
use App\Jobs\UnmarkThreadSolution;
use App\Jobs\UpdateThread;
use App\Models\Thread;
use App\Models\Topic;
use App\Http\Requests\ThreadRequest;
use App\Jobs\DeleteThread;
use App\Models\Reply;
use App\Models\Tag;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed'], ['except' => ['overview', 'show']]);
    }

    public function overview()
    {
        return view('forum.overview', [
            'topics' => Topic::all(),
            'threads' => Thread::findAllPaginated(),
        ]);
    }

    public function show(Thread $thread)
    {
        return view('forum.threads.show', compact('thread'));
    }

    public function create()
    {
        return view('forum.threads.create', ['topics' => Topic::all(), 'tags' => Tag::all()]);
    }

    public function store(ThreadRequest $request)
    {
        $thread = $this->dispatchNow(CreateThread::fromRequest($request));

        $this->success('forum.threads.created');

        return redirect()->route('thread', $thread->slug());
    }

    public function edit(Thread $thread)
    {
        $this->authorize('update', $thread);

        return view('forum.threads.edit', ['thread' => $thread, 'topics' => Topic::all(), 'tags' => Tag::all()]);
    }

    public function update(ThreadRequest $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread = $this->dispatchNow(UpdateThread::fromRequest($thread, $request));

        $this->success('forum.threads.updated');

        return redirect()->route('thread', $thread->slug());
    }

    public function delete(Thread $thread)
    {
        $this->authorize('delete', $thread);

        $this->dispatchNow(new DeleteThread($thread));

        $this->success('forum.threads.deleted');

        return redirect()->route('forum');
    }

    public function markSolution(Thread $thread, Reply $reply)
    {
        $this->authorize('update', $thread);

        $this->dispatchNow(new MarkThreadSolution($thread, $reply));

        return redirect()->route('thread', $thread->slug());
    }

    public function unmarkSolution(Thread $thread)
    {
        $this->authorize('update', $thread);

        $this->dispatchNow(new UnmarkThreadSolution($thread));

        return redirect()->route('thread', $thread->slug());
    }
}
