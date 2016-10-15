<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Forum\Thread;
use App\Forum\ThreadRepository;
use App\Replies\ReplyRequest;
use App\Replies\Reply;
use App\Replies\ReplyAble;
use App\Replies\ReplyRepository;

class ReplyController extends Controller
{
    /**
     * @var \App\Replies\ReplyRepository
     */
    private $replies;

    /**
     * @var \App\Forum\ThreadRepository
     */
    private $threads;

    public function __construct(ReplyRepository $replies, ThreadRepository $threads)
    {
        $this->threads = $threads;
        $this->replies = $replies;

        $this->middleware(['auth', 'confirmed']);
    }

    public function store(ReplyRequest $request)
    {
        $replyAble = $this->findReplyAble($request->get('replyable_id'), $request->get('replyable_type'));

        $this->replies->create($replyAble, $request->user(), $request->get('body'), ['ip' => $request->ip()]);

        $this->success('replies.created');

        return $this->redirectToReplyAble($replyAble);
    }

    public function edit(Reply $reply)
    {
        $this->authorize('update', $reply);

        return view('replies.edit', compact('reply'));
    }

    public function update(ReplyRequest $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->replies->update($reply, $request->only('body'));

        $this->success('replies.updated');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function delete(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $this->replies->delete($reply);

        $this->success('replies.deleted');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    private function findReplyAble(int $id, string $type): ReplyAble
    {
        switch ($type) {
            case Thread::TYPE:
                return $this->threads->find($id);
        }

        abort(404);
    }

    private function redirectToReplyAble(ReplyAble $replyAble): RedirectResponse
    {
        if ($replyAble instanceof Thread) {
            return redirect()->route('thread', $replyAble->slug());
        }

        abort(404);
    }
}
