<?php

namespace App\Http\Controllers;

use App\Forum\Thread;
use App\Forum\ThreadRepository;
use App\Forum\TopicRepository;
use App\Http\Requests\ThreadRequest;
use App\Jobs\DeleteThread;
use App\Replies\Reply;
use App\Tags\TagRepository;

class ThreadsController extends Controller
{
    /**
     * @var \App\Forum\ThreadRepository
     */
    private $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;

        $this->middleware(['auth', 'confirmed'], ['except' => ['overview', 'show']]);
    }

    public function overview(TopicRepository $topics)
    {
        return view('forum.overview', [
            'topics' => $topics->findAll(),
            'threads' => $this->threads->findAllPaginated(),
        ]);
    }

    public function show(Thread $thread)
    {
        return view('forum.threads.show', compact('thread'));
    }

    public function create(TopicRepository $topics, TagRepository $tags)
    {
        return view('forum.threads.create', ['topics' => $topics->findAll(), 'tags' => $tags->findAll()]);
    }

    public function store(ThreadRequest $request)
    {
        $thread = $this->threads->create($request);

        $this->success('forum.threads.created');

        return redirect()->route('thread', $thread->slug());
    }

    public function edit(TopicRepository $topics, TagRepository $tags, Thread $thread)
    {
        $this->authorize('update', $thread);

        return view('forum.threads.edit', [
            'topics' => $topics->findAll(),
            'thread' => $thread,
            'tags' => $tags->findAll(),
        ]);
    }

    public function update(ThreadRequest $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $this->threads->update($thread, $request->changed());

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

        $this->threads->markSolution($reply);

        return redirect()->route('thread', $thread->slug());
    }

    public function unmarkSolution(Thread $thread)
    {
        $this->authorize('update', $thread);

        $this->threads->unmarkSolution($thread);

        return redirect()->route('thread', $thread->slug());
    }
}
