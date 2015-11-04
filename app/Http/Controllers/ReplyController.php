<?php
namespace Lio\Http\Controllers;

use Illuminate\Http\Request;
use Lio\Forum\EloquentThread;
use Lio\Forum\Thread;
use Lio\Forum\ThreadRepository;
use Lio\Replies\ReplyAble;
use Lio\Replies\ReplyRepository;

class ReplyController extends Controller
{
    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    public function store(ReplyRepository $replies, Request $request)
    {
        $replyAble = $this->findReplyAble($request->get('replyable_id'), $request->get('replyable_type'));

        $replies->create($replyAble, auth()->user(), $request->get('body'));

        return $this->redirectToReplyAble($replyAble);
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
