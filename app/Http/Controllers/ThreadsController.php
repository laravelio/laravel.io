<?php

namespace App\Http\Controllers;

use App\Forum\Thread;
use App\Forum\Topic;
use App\Http\Requests\ThreadRequest;
use App\Jobs\DeleteThread;
use App\Replies\Reply;
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
        $thread = Thread::createFromData($request);

        $this->success('forum.threads.created');

        return redirect()->route('thread', $thread->slug());
    }

    public function edit(Thread $thread)
    {
        $this->authorize('update', $thread);

        return view('forum.threads.edit', [
            'topics' => Topic::all(),
            'thread' => $thread,
            'tags' => Tag::all(),
        ]);
    }

    public function update(ThreadRequest $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->updateFromRequest($thread, $request->changed());

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

        $thread->markSolution($reply);

        return redirect()->route('thread', $thread->slug());
    }

    public function unmarkSolution(Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->unmarkSolution();

        return redirect()->route('thread', $thread->slug());
    }
}
