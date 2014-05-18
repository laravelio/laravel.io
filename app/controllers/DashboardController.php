<?php

use Illuminate\Auth\AuthManager;
use Lio\Forum\Replies\ReplyRepository;
use Lio\Forum\Threads\ThreadRepository;

class DashboardController extends BaseController
{
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var Lio\Forum\Threads\ThreadRepository
     */
    private $threadRepository;
    /**
     * @var Lio\Forum\Replies\ReplyRepository
     */
    private $replyRepository;

    public function __construct(AuthManager $auth, ThreadRepository $threadRepository, ReplyRepository $replyRepository)
    {
        $this->auth = $auth;
        $this->threadRepository = $threadRepository;
        $this->replyRepository = $replyRepository;
    }

    public function getIndex()
    {
        $user = $this->auth->user();
        $threads = $this->threadRepository->getRecentByUser($user);
        $replies = $this->replyRepository->getRecentByUser($user);
        $this->renderView('dashboard.index', compact('user', 'threads', 'replies'));
    }
}
