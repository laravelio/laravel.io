<?php

use Lio\Accounts\UserRepository;

class UsersController extends BaseController
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getProfile($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(5);
        $replies = $user->getLatestRepliesPaginated(5);

        $this->view('users.profile', compact('user', 'threads', 'replies'));
    }

    public function getThreads($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(10);

        $this->view('users.threads', compact('user', 'threads'));
    }

    public function getReplies($userName)
    {
        $user = $this->users->requireByName($userName);

        $replies = $user->getLatestRepliesPaginated(10);

        $this->view('users.replies', compact('user', 'replies'));
    }
}