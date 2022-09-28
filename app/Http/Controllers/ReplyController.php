<?php

namespace App\Http\Controllers;

use App\Contracts\ReplyAble;
use App\Http\Requests\CreateReplyRequest;
use App\Jobs\CreateReply;
use App\Jobs\DeleteReply;
use App\Jobs\ReportSpam;
use App\Models\Reply;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, EnsureEmailIsVerified::class]);
    }

    public function store(CreateReplyRequest $request)
    {
        $this->authorize(ReplyPolicy::CREATE, Reply::class);

        $this->dispatchSync(CreateReply::fromRequest($request, $uuid = Str::uuid()));

        $reply = Reply::findByUuidOrFail($uuid);

        $this->success('replies.created');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function delete(Request $request, Reply $reply)
    {
        $this->authorize(ReplyPolicy::DELETE, $reply);

        $this->dispatchSync(new DeleteReply($reply, $request->delete_reason));

        $this->success('replies.deleted');

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function markAsSpam(Request $request, Reply $reply)
    {
        $this->authorize(ReplyPolicy::REPORT_SPAM, $reply);

        $this->dispatchSync(new ReportSpam($request->user(), $reply));

        $this->success("We've received your spam report. Thanks for helping us keep the forum clean!");

        return $this->redirectToReplyAble($reply->replyAble());
    }

    private function redirectToReplyAble(ReplyAble $replyAble): RedirectResponse
    {
        if ($replyAble instanceof Thread) {
            return redirect()->route('thread', $replyAble->slug());
        }

        abort(500, 'Redirect not implemented for given replyable.');
    }
}
