<?php namespace Lio\Contributors;

use Lio\Accounts\UserRepository;

class ContributorImporter
{
    private $users;
    private $contributors;

    public function __construct(UserRepository $users, ContributorRepository $contributors)
    {
        $this->users        = $users;
        $this->contributors = $contributors;
    }

    public function import()
    {
        $records = $this->getContributors();

        foreach ($records as $record) {
            $this->addOrUpdateContributor($record);
        }
    }

    private function addOrUpdateContributor($record)
    {
        $contributor = $this->contributors->getByGitHubId($record->id);

        if ( ! $contributor) {
            $contributor = $this->contributors->getNew();
        }

        $contributor->fill([
            'github_id'           => $record->id,
            'name'                => $record->login,
            'avatar_url'          => $record->avatar_url,
            'github_url'          => $record->html_url,
            'contribution_count' => $record->contributions,
        ]);

        $this->contributors->save($contributor);
    }

    private function getContributors()
    {
        $json = file_get_contents('https://api.github.com/repos/LaravelIO/laravel-io/contributors');

        if (empty($json)) return [];

        return json_decode($json);
    }
}