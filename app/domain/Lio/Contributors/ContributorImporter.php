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

    public function import(array $repos)
    {
        $contributors = [];

        foreach ($repos as $repo) {
            $contributors = array_merge($contributors, (array) $this->getRepoContributors($repo));
        }

        $contributors = $this->combineContributorRecords($contributors);

        foreach ($contributors as $contributor) {
            $this->addOrUpdateContributor($contributor);
        }
    }

    private function combineContributorRecords(array $contributors)
    {
        $combined = [];

        foreach ($contributors as $contributor) {
            $combinedIds = array_pluck($combined, 'id');

            $key = array_search($contributor->id, $combinedIds);

            if ($key) {
                $combined[$key]->contributions += $contributor->contributions;
                continue;
            }

            $combined[] = $contributor;
        }


        return $combined;
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

    private function getRepoContributors($repo)
    {
        $json = file_get_contents("https://api.github.com/repos/{$repo}/contributors");

        if (empty($json)) return [];

        return json_decode($json);
    }
}