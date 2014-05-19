<?php

use Lio\Accounts\EloquentMemberRepository;

class ProfileController extends BaseController
{
    private $users;

    public function __construct(EloquentMemberRepository $users)
    {
        $this->users = $users;
    }

    public function getShow($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(5);
        $replies = $user->getLatestRepliesPaginated(5);

        $this->render('users.profile', compact('user', 'threads', 'replies'));
    }
}
