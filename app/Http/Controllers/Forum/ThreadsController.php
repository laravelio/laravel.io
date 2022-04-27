<?php

namespace App\Http\Controllers\Forum;

use App\Concerns\UsesFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Jobs\CreateThread;
use App\Jobs\DeleteThread;
use App\Jobs\LockThread;
use App\Jobs\MarkThreadSolution;
use App\Jobs\SubscribeToSubscriptionAble;
use App\Jobs\UnlockThread;
use App\Jobs\UnmarkThreadSolution;
use App\Jobs\UnsubscribeFromSubscriptionAble;
use App\Jobs\UpdateThread;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use App\Policies\ThreadPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ThreadsController extends Controller
{
    use UsesFilters;

    public function __construct()
    {
        $this->middleware([Authenticate::class, EnsureEmailIsVerified::class], ['except' => ['overview', 'show']]);
    }

    public function overview()
    {
        $threads = [];
        $filter = $this->getFilter();

        if ($filter === 'recent') {
            $threads = Thread::feedPaginated();
        }

        if ($filter === 'resolved') {
            $threads = Thread::feedQuery()
                ->resolved()
                ->paginate(20);
        }

        if ($filter === 'unresolved') {
            $threads = Thread::feedQuery()
                ->unresolved()
                ->paginate(20);
        }

        $tags = Tag::orderBy('name')->get();
        $topMembers = Cache::remember('topMembers', now()->addMinutes(30), function () {
            return User::mostSolutionsInLastDays(365)->take(5)->get();
        });
        $moderators = Cache::remember('moderators', now()->addMinutes(30), function () {
            return User::moderators()->get();
        });
        $canonical = canonical('forum', ['filter' => $filter]);

        return view('forum.overview', compact('threads', 'filter', 'tags', 'topMembers', 'moderators', 'canonical'));
    }

    public function show(Thread $thread)
    {
        $moderators = Cache::remember('moderators', now()->addMinutes(30), function () {
            return User::moderators()->get();
        });

        return view('forum.threads.show', compact('thread', 'moderators'));
    }

    public function create()
    {
        $tags = Tag::all();
        $selectedTags = old('tags') ?: [];

        return view('forum.threads.create', ['tags' => $tags, 'selectedTags' => $selectedTags]);
    }

    public function store(ThreadRequest $request)
    {
        $this->dispatchSync(CreateThread::fromRequest($request, $uuid = Str::uuid()));

        $thread = Thread::findByUuidOrFail($uuid);

        $this->success('forum.threads.created');

        return redirect()->route('thread', $thread->slug());
    }

    public function edit(Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $selectedTags = $thread->tags()->pluck('id')->toArray();

        return view('forum.threads.edit', ['thread' => $thread, 'tags' => Tag::all(), 'selectedTags' => $selectedTags]);
    }

    public function update(ThreadRequest $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $this->dispatchSync(UpdateThread::fromRequest($thread, $request));

        $thread = $thread->fresh();

        $this->success('forum.threads.updated');

        return redirect()->route('thread', $thread->slug());
    }

    public function delete(Thread $thread)
    {
        $this->authorize(ThreadPolicy::DELETE, $thread);

        $this->dispatchSync(new DeleteThread($thread));

        $this->success('forum.threads.deleted');

        return redirect()->route('forum');
    }

    public function lock(Request $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::LOCK, $thread);

        if ($thread->isLocked()) {
            $this->dispatchSync(new UnlockThread($thread));

            $this->success('forum.threads.unlocked');
        } else {
            $this->dispatchSync(new LockThread($request->user(), $thread));

            $this->success('forum.threads.locked');
        }

        return redirect()->route('thread', $thread->slug());
    }

    public function markSolution(Thread $thread, Reply $reply)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $this->dispatchSync(new MarkThreadSolution($thread, $reply, Auth::user()));

        return redirect()->route('thread', $thread->slug());
    }

    public function unmarkSolution(Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $this->dispatchSync(new UnmarkThreadSolution($thread));

        return redirect()->route('thread', $thread->slug());
    }

    public function subscribe(Request $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::SUBSCRIBE, $thread);

        $this->dispatchSync(new SubscribeToSubscriptionAble($request->user(), $thread));

        $this->success("You're now subscribed to this thread.");

        return redirect()->route('thread', $thread->slug());
    }

    public function unsubscribe(Request $request, Thread $thread)
    {
        $this->authorize(ThreadPolicy::UNSUBSCRIBE, $thread);

        $this->dispatchSync(new UnsubscribeFromSubscriptionAble($request->user(), $thread));

        $this->success("You're now unsubscribed from this thread.");

        return redirect()->route('thread', $thread->slug());
    }
}
