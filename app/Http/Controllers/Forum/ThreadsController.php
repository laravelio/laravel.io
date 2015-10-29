<?php
namespace Lio\Http\Controllers\Forum;

use Lio\Forum\Thread;
use Lio\Http\Controllers\Controller;
use Lio\Forum\ThreadRepository;

class ThreadsController extends Controller
{
    public function overview(ThreadRepository $threads)
    {
        return view('forum.overview', ['threads' => $threads->findAll()]);
    }

    public function show(Thread $thread)
    {
        return view('forum.threads.show', compact('thread'));
    }
}
