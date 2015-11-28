<?php
namespace Lio\Http\Controllers;

use Lio\Forum\Thread;
use Lio\Forum\ThreadRepository;
use Lio\Replies\CreateReplyRequest;
use Lio\Replies\UpdateReplyRequest;
use Lio\Replies\Reply;
use Lio\Replies\ReplyAble;
use Lio\Replies\ReplyRepository;

class ReplyController extends Controller
{
    /**
     * @var \Lio\Replies\ReplyRepository
     */
    private $replies;

    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threads;

    public function __construct(ReplyRepository $replies, ThreadRepository $threads)
    {
        $this->threads = $threads;
        $this->replies = $replies;

        $this->middleware('auth');
    }

    public function store(CreateReplyRequest $request)
    {
        $replyAble = $this->findReplyAble($request->get('replyable_id'), $request->get('replyable_type'));

        $this->replies->create($replyAble, auth()->user(), $request->get('body'));

        return $this->redirectToReplyAble($replyAble);
    }

    public function edit(Reply $reply)
    {
        return view('replies.edit', compact('reply'));
    }

    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        $this->replies->update($reply, $request->only('body'));

        return $this->redirectToReplyAble($reply->replyAble());
    }

    public function delete(Reply $reply)
    {
        $this->replies->delete($reply);

        return $this->redirectToReplyAble($reply->replyAble());
    }

    /**
     * @param int $id
     * @param string $type
     * @return \Lio\Replies\ReplyAble
     */
    private function findReplyAble($id, $type)
    {
        switch ($type) {
            case Thread::TYPE:
                return $this->threads->find($id);
        }

        abort(404);
    }

    /**
     * @param \Lio\Replies\ReplyAble $replyAble
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToReplyAble(ReplyAble $replyAble)
    {
        if ($replyAble instanceof Thread) {
            return redirect()->route('thread', $replyAble->slug());
        }

        abort(500); // Todo: find better error method
    }
}
