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
        $comments = $user->getLatestRepliesPaginated(5);

        $this->view('users.profile', compact('user', 'threads', 'comments'));
    }
}