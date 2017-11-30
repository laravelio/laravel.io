<?php

namespace App\Http\Controllers\Forum;

use App\Models\Tag;
use App\Models\Reply;
use App\Models\Thread;
use App\Jobs\CreateThread;
use App\Jobs\DeleteThread;
use App\Jobs\UpdateThread;
use App\Policies\ThreadPolicy;
use App\Queries\SearchThreads;
use App\Jobs\MarkThreadSolution;
use App\Jobs\UnmarkThreadSolution;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Jobs\SubscribeToSubscriptionAble;
use Illuminate\Auth\Middleware\Authenticate;
use App\Jobs\UnsubscribeFromSubscriptionAble;
use App\Http\Middleware\RedirectIfUnconfirmed;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, RedirectIfUnconfirmed::class], ['except' => ['overview', 'show']]);
    }

    public function overview()
    {
        $search = request('search');
        $threads = $search ? SearchThreads::get($search) : Thread::feedPaginated();

        return view('forum.overview', compact('threads', 'search'));
    }

    public function show(Thread $thread)
    {
        return view('forum.threads.show', compact('thread'));
    }

    public function create()
    {
        return view('forum.threads.create', ['tags' => Tag::all()]);
    }

    public function store(ThreadRequest $request)
    {
        $thread = $this->dispatchNow(CreateThread::fromRequest($request));

        $this->success('forum.threads.created');

        return redirect()->route('thread', $thread->slug());
    }

    public function edit(Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        return view('forum.threads.edit', ['thread' => $thread, 'tags' => Tag::all()]);
    }

    public function update(ThreadRequest $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $thread = $this->dispatchNow(UpdateThread::fromRequest($thread, $request));

        $this->success('forum.threads.updated');

        return redirect()->route('thread', $thread->slug());
    }

    public function delete(Thread $thread)
    {
        $this->authorize(ThreadPolicy::DELETE, $thread);

        $this->dispatchNow(new DeleteThread($thread));

        $this->success('forum.threads.deleted');

        return redirect()->route('forum');
    }

    public function markSolution(Thread $thread, Reply $reply)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $this->dispatchNow(new MarkThreadSolution($thread, $reply));

        return redirect()->route('thread', $thread->slug());
    }

    public function unmarkSolution(Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $this->dispatchNow(new UnmarkThreadSolution($thread));

        return redirect()->route('thread', $thread->slug());
    }

    public function subscribe(Request $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::SUBSCRIBE, $thread);

        $this->dispatchNow(new SubscribeToSubscriptionAble($request->user(), $thread));

        $this->success("You're now subscribed to this thread.");

        return redirect()->route('thread', $thread->slug());
    }

    public function unsubscribe(Request $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::UNSUBSCRIBE, $thread);

        $this->dispatchNow(new UnsubscribeFromSubscriptionAble($request->user(), $thread));

        $this->success("You're now unsubscribed from this thread.");

        return redirect()->route('thread', $thread->slug());
    }
}
