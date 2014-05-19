<?php

use Illuminate\Auth\AuthManager;
use Lio\Forum\EloquentReplyRepository;
use Lio\Forum\EloquentThreadRepository;

class DashboardController extends BaseController
{
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Lio\Forum\EloquentThreadRepository
     */
    private $threadRepository;
    /**
     * @var \Lio\Forum\EloquentReplyRepository
     */
    private $replyRepository;

    public function __construct(AuthManager $auth, EloquentThreadRepository $threadRepository, EloquentReplyRepository $replyRepository)
    {
        $this->auth = $auth;
        $this->threadRepository = $threadRepository;
        $this->replyRepository = $replyRepository;
    }

    public function getIndex()
    {
        $user = $this->auth->user();
        $threads = $this->threadRepository->getRecentByMember($user);
        $replies = $this->replyRepository->getRecentByMember($user);
        $this->render('dashboard.index', compact('user', 'threads', 'replies'));
    }
}
