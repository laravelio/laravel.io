<?php
namespace Lio\Http\Controllers\Forum;

use Lio\Forum\Thread;
use Lio\Forum\ThreadRequest;
use Lio\Http\Controllers\Controller;
use Lio\Forum\ThreadRepository;

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

    public function overview()
    {
        return view('forum.overview', ['threads' => $this->threads->findAllPaginated()]);
    }

    public function show(Thread $thread)
    {
        return view('forum.threads.show', compact('thread'));
    }

    public function create()
    {
        return view('forum.threads.create');
    }

    public function store(ThreadRequest $request)
    {
        $thread = $this->threads->create(auth()->user(), $request->get('subject'), $request->get('body'));

        return redirect()->route('thread', $thread->slug());
    }

    public function edit(Thread $thread)
    {
        return view('forum.threads.edit', compact('thread'));
    }

    public function update(ThreadRequest $request, Thread $thread)
    {
        $this->threads->update($thread, $request->only('subject', 'body'));

        return redirect()->route('thread', $thread->slug());
    }

    public function delete(Thread $thread)
    {
        $this->threads->delete($thread);

        return redirect()->route('forum');
    }
}
