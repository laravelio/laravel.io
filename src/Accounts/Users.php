<?php namespace Lio\Accounts;

use Lio\Events\EventGenerator;
use Lio\Github\GithubUser;

class Users
{
    use EventGenerator;

    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function addUserFromGithub(GithubUser $github)
    {
        $user = new User([
            'email' => $github->email,
            'name' => $github->name,
            'github_url' => $github->githubUrl,
            'github_id' => $github->githubId,
            'image_url' => $github->imageUrl,
        ]);
        return $user;
    }

    public function updateUserFromGithub(User $user, GithubUser $github)
    {
        $user->fill([
            'email' => $github->email,
            'name' => $github->name,
            'github_url' => $github->githubUrl,
            'github_id' => $github->githubId,
            'image_url' => $github->imageUrl,
        ]);
        return $user;
    }

    public function banUser(User $problem, User $admin)
    {
        $problem->ban();
        return $problem;
    }
} 
