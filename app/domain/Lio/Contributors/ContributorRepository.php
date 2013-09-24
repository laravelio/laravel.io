<?php namespace Lio\Contributors;

use Lio\Core\EloquentBaseRepository;

class ContributorRepository extends EloquentBaseRepository
{
    public function __construct(Contributor $model)
    {
        $this->model = $model;
    }

    public function getByGitHubId($githubId)
    {
        return $this->model->where('github_id', '=', $githubId)->first();
    }
}
