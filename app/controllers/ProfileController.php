<?php

use Lio\Accounts\UserRepository;

class ProfileController extends BaseController
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getShow($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(5);
        $replies = $user->getLatestRepliesPaginated(5);

        $this->view('users.profile', compact('user', 'threads', 'replies'));
    }
}
