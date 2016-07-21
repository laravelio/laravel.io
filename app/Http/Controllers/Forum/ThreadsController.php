<?php

namespace Lio\Http\Controllers\Forum;

use Lio\Forum\Thread;
use Lio\Forum\ThreadRequest;
use Lio\Forum\Topics\TopicRepository;
use Lio\Http\Controllers\Controller;
use Lio\Forum\ThreadRepository;
use Lio\Tags\TagRepository;

class ThreadsController extends Controller
{
    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;

        $this->middleware('auth', ['except' => ['overview', 'show']]);
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
        $thread = $this->threads->create(
            auth()->user(),
            $request->topic(),
            $request->get('subject'),
            $request->get('body'),
            $request->dataForStore()
        );

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

        $this->threads->update($thread, $request->dataForUpdate());

        return redirect()->route('thread', $thread->slug());
    }

    public function delete(Thread $thread)
    {
        $this->authorize('delete', $thread);

        $this->threads->delete($thread);

        return redirect()->route('forum');
    }
}
