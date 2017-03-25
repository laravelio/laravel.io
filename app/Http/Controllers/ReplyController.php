<?php

namespace App\Http\Controllers;

use App\Forum\Thread;
use App\Http\Requests\ReplyRequest;
use App\Replies\Reply;
use App\Replies\ReplyAble;
use App\Replies\ReplyRepository;
use Illuminate\Http\RedirectResponse;

class ReplyController extends Controller
{
    /**
     * @var \App\Replies\ReplyRepository
     */
    private $replies;

    public function __construct(ReplyRepository $replies)
    {
        $this->replies = $replies;

        $this->middleware(['auth', 'confirmed']);
    }

    public function store(ReplyRequest $request)
    {
        $reply = $this->replies->create($request);

        $this->success('replies.created');

        return $this->redirectToReplyAble($reply->replyAble());
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

    private function redirectToReplyAble(ReplyAble $replyAble): RedirectResponse
    {
        abort_unless($replyAble instanceof Thread, 404);

        return redirect()->route('thread', $replyAble->slug());
    }
}
