<?php namespace Controllers;

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
        $user->load(['mostRecentFiveForumPosts', 'mostRecentFiveForumPosts.parent', 'mostRecentFiveForumPosts.slug']);

        $this->view('users.profile', compact('user'));
    }
}