<?php namespace Lio\Accounts;

use Lio\Core\EloquentBaseRepository;
use GitHub;

class UserRepository extends EloquentBaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getByGithubId($id)
    {
        return $this->model->where('github_id', '=', $id)->first();
    }

    public function getFirstX($count)
    {
        return $this->model->take($count)->get();
    }

    public function updateFromGithubData($user, $githubUser)
    {
        $user->fill([
            'name'       => $githubUser['name'],
            'email'      => $githubUser['email'],
            'github_id'  => $githubUser['id'],
            'github_url' => $githubUser['html_url'],
        ]);
    }
}
