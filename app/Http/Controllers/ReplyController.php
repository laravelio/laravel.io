<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }

    public function store(ReplyRequest $request)
    {
        $reply = Reply::createFromRequest($request);

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

        $reply->update($request->only('body'));

        $this->success('replies.updated');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function delete(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        $this->success('replies.deleted');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    private function redirectToReplyAble($replyAble): RedirectResponse
    {
        abort_unless($replyAble instanceof Thread, 404);

        return redirect()->route('thread', $replyAble->slug());
    }
}
