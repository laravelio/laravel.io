<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfUnconfirmed;
use App\Http\Requests\CreateReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Jobs\DislikeReply;
use App\Jobs\LikeReply;
use App\Jobs\CreateReply;
use App\Jobs\DeleteReply;
use App\Jobs\UpdateReply;
use App\Models\Reply;
use App\Models\ReplyAble;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, RedirectIfUnconfirmed::class]);
    }

    public function store(CreateReplyRequest $request)
    {
        $this->authorize(ReplyPolicy::CREATE, Reply::class);

        $reply = $this->dispatchNow(CreateReply::fromRequest($request));

        $this->success('replies.created');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function edit(Reply $reply)
    {
        $this->authorize(ReplyPolicy::UPDATE, $reply);

        return view('replies.edit', compact('reply'));
    }

    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        $this->authorize(ReplyPolicy::UPDATE, $reply);

        $this->dispatchNow(new UpdateReply($reply, $request->body()));

        $this->success('replies.updated');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function delete(Reply $reply)
    {
        $this->authorize(ReplyPolicy::DELETE, $reply);

        $this->dispatchNow(new DeleteReply($reply));

        $this->success('replies.deleted');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function like(Reply $reply)
    {
        $this->dispatchNow(new LikeReply($reply, auth()->user()));

        return back();
    }

    public function dislike(Reply $reply)
    {
        $this->dispatchNow(new DislikeReply($reply, auth()->user()));

        return back();
    }

    private function redirectToReplyAble(ReplyAble $replyAble): RedirectResponse
    {
        if ($replyAble instanceof Thread) {
            return redirect()->route('thread', $replyAble->slug());
        }

        abort(500, 'Redirect not implemented for given replyable.');
    }
}
