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
$json =<<<EOF
[
  {
    "login": "ShawnMcCool",
    "id": 560749,
    "avatar_url": "https://1.gravatar.com/avatar/c7d7ea7ed7cdf742ebc2c9445b9928c3?d=https%3A%2F%2Fidenticons.github.com%2F5acd34b4fee131776d30ebf26350f99e.png",
    "gravatar_id": "c7d7ea7ed7cdf742ebc2c9445b9928c3",
    "url": "https://api.github.com/users/ShawnMcCool",
    "html_url": "https://github.com/ShawnMcCool",
    "followers_url": "https://api.github.com/users/ShawnMcCool/followers",
    "following_url": "https://api.github.com/users/ShawnMcCool/following{/other_user}",
    "gists_url": "https://api.github.com/users/ShawnMcCool/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/ShawnMcCool/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/ShawnMcCool/subscriptions",
    "organizations_url": "https://api.github.com/users/ShawnMcCool/orgs",
    "repos_url": "https://api.github.com/users/ShawnMcCool/repos",
    "events_url": "https://api.github.com/users/ShawnMcCool/events{/privacy}",
    "received_events_url": "https://api.github.com/users/ShawnMcCool/received_events",
    "type": "User",
    "contributions": 139
  },
  {
    "login": "clauddiu",
    "id": 497165,
    "avatar_url": "https://2.gravatar.com/avatar/d0cf877e2558754ccbba0dce43e182f5?d=https%3A%2F%2Fidenticons.github.com%2Ff50b7b9d891a79b59570b7ec1fa42486.png",
    "gravatar_id": "d0cf877e2558754ccbba0dce43e182f5",
    "url": "https://api.github.com/users/clauddiu",
    "html_url": "https://github.com/clauddiu",
    "followers_url": "https://api.github.com/users/clauddiu/followers",
    "following_url": "https://api.github.com/users/clauddiu/following{/other_user}",
    "gists_url": "https://api.github.com/users/clauddiu/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/clauddiu/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/clauddiu/subscriptions",
    "organizations_url": "https://api.github.com/users/clauddiu/orgs",
    "repos_url": "https://api.github.com/users/clauddiu/repos",
    "events_url": "https://api.github.com/users/clauddiu/events{/privacy}",
    "received_events_url": "https://api.github.com/users/clauddiu/received_events",
    "type": "User",
    "contributions": 13
  },
  {
    "login": "driesvints",
    "id": 594614,
    "avatar_url": "https://2.gravatar.com/avatar/e8321183acdf47a9ce838afd13a964b5?d=https%3A%2F%2Fidenticons.github.com%2F31c8f0fc200a996d1e496fd55654cef4.png",
    "gravatar_id": "e8321183acdf47a9ce838afd13a964b5",
    "url": "https://api.github.com/users/driesvints",
    "html_url": "https://github.com/driesvints",
    "followers_url": "https://api.github.com/users/driesvints/followers",
    "following_url": "https://api.github.com/users/driesvints/following{/other_user}",
    "gists_url": "https://api.github.com/users/driesvints/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/driesvints/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/driesvints/subscriptions",
    "organizations_url": "https://api.github.com/users/driesvints/orgs",
    "repos_url": "https://api.github.com/users/driesvints/repos",
    "events_url": "https://api.github.com/users/driesvints/events{/privacy}",
    "received_events_url": "https://api.github.com/users/driesvints/received_events",
    "type": "User",
    "contributions": 10
  },
  {
    "login": "Nickstr",
    "id": 1457095,
    "avatar_url": "https://2.gravatar.com/avatar/3bf7a86435c01ce9087abd902d1314e8?d=https%3A%2F%2Fidenticons.github.com%2F09ef35c1ace6d7c9a21f48da485449ee.png",
    "gravatar_id": "3bf7a86435c01ce9087abd902d1314e8",
    "url": "https://api.github.com/users/Nickstr",
    "html_url": "https://github.com/Nickstr",
    "followers_url": "https://api.github.com/users/Nickstr/followers",
    "following_url": "https://api.github.com/users/Nickstr/following{/other_user}",
    "gists_url": "https://api.github.com/users/Nickstr/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/Nickstr/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/Nickstr/subscriptions",
    "organizations_url": "https://api.github.com/users/Nickstr/orgs",
    "repos_url": "https://api.github.com/users/Nickstr/repos",
    "events_url": "https://api.github.com/users/Nickstr/events{/privacy}",
    "received_events_url": "https://api.github.com/users/Nickstr/received_events",
    "type": "User",
    "contributions": 9
  },
  {
    "login": "jeroengerits",
    "id": 808734,
    "avatar_url": "https://0.gravatar.com/avatar/eaa7cead553d8ed60a916ef2501fc085?d=https%3A%2F%2Fidenticons.github.com%2Fcc550fad664cbd72af20291d45d7bf39.png",
    "gravatar_id": "eaa7cead553d8ed60a916ef2501fc085",
    "url": "https://api.github.com/users/jeroengerits",
    "html_url": "https://github.com/jeroengerits",
    "followers_url": "https://api.github.com/users/jeroengerits/followers",
    "following_url": "https://api.github.com/users/jeroengerits/following{/other_user}",
    "gists_url": "https://api.github.com/users/jeroengerits/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/jeroengerits/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/jeroengerits/subscriptions",
    "organizations_url": "https://api.github.com/users/jeroengerits/orgs",
    "repos_url": "https://api.github.com/users/jeroengerits/repos",
    "events_url": "https://api.github.com/users/jeroengerits/events{/privacy}",
    "received_events_url": "https://api.github.com/users/jeroengerits/received_events",
    "type": "User",
    "contributions": 6
  },
  {
    "login": "AnthonyConklin",
    "id": 3253600,
    "avatar_url": "https://1.gravatar.com/avatar/754afe85cc019567279318a4118c4dff?d=https%3A%2F%2Fidenticons.github.com%2Fd983eae831f1400189abe2a2b046895a.png",
    "gravatar_id": "754afe85cc019567279318a4118c4dff",
    "url": "https://api.github.com/users/AnthonyConklin",
    "html_url": "https://github.com/AnthonyConklin",
    "followers_url": "https://api.github.com/users/AnthonyConklin/followers",
    "following_url": "https://api.github.com/users/AnthonyConklin/following{/other_user}",
    "gists_url": "https://api.github.com/users/AnthonyConklin/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/AnthonyConklin/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/AnthonyConklin/subscriptions",
    "organizations_url": "https://api.github.com/users/AnthonyConklin/orgs",
    "repos_url": "https://api.github.com/users/AnthonyConklin/repos",
    "events_url": "https://api.github.com/users/AnthonyConklin/events{/privacy}",
    "received_events_url": "https://api.github.com/users/AnthonyConklin/received_events",
    "type": "User",
    "contributions": 5
  },
  {
    "login": "mitchellvanw",
    "id": 3061428,
    "avatar_url": "https://2.gravatar.com/avatar/8ec7677ac867a3e2d2e5decc96cfb03c?d=https%3A%2F%2Fidenticons.github.com%2F88812a899a23496a74b03df518ea263f.png",
    "gravatar_id": "8ec7677ac867a3e2d2e5decc96cfb03c",
    "url": "https://api.github.com/users/mitchellvanw",
    "html_url": "https://github.com/mitchellvanw",
    "followers_url": "https://api.github.com/users/mitchellvanw/followers",
    "following_url": "https://api.github.com/users/mitchellvanw/following{/other_user}",
    "gists_url": "https://api.github.com/users/mitchellvanw/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/mitchellvanw/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/mitchellvanw/subscriptions",
    "organizations_url": "https://api.github.com/users/mitchellvanw/orgs",
    "repos_url": "https://api.github.com/users/mitchellvanw/repos",
    "events_url": "https://api.github.com/users/mitchellvanw/events{/privacy}",
    "received_events_url": "https://api.github.com/users/mitchellvanw/received_events",
    "type": "User",
    "contributions": 3
  },
  {
    "login": "JoelLarson",
    "id": 519553,
    "avatar_url": "https://2.gravatar.com/avatar/6423c07af1b8c92df8b223ce34ce13d8?d=https%3A%2F%2Fidenticons.github.com%2Fa71eb3986a3fcee05f0e4215fa0fb65e.png",
    "gravatar_id": "6423c07af1b8c92df8b223ce34ce13d8",
    "url": "https://api.github.com/users/JoelLarson",
    "html_url": "https://github.com/JoelLarson",
    "followers_url": "https://api.github.com/users/JoelLarson/followers",
    "following_url": "https://api.github.com/users/JoelLarson/following{/other_user}",
    "gists_url": "https://api.github.com/users/JoelLarson/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/JoelLarson/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/JoelLarson/subscriptions",
    "organizations_url": "https://api.github.com/users/JoelLarson/orgs",
    "repos_url": "https://api.github.com/users/JoelLarson/repos",
    "events_url": "https://api.github.com/users/JoelLarson/events{/privacy}",
    "received_events_url": "https://api.github.com/users/JoelLarson/received_events",
    "type": "User",
    "contributions": 1
  },
  {
    "login": "ianlandsman",
    "id": 53144,
    "avatar_url": "https://1.gravatar.com/avatar/b5f65623463f621147d67fe42dbd4cb5?d=https%3A%2F%2Fidenticons.github.com%2F57f2b3cf26b3d12b9ecd389b401a1300.png",
    "gravatar_id": "b5f65623463f621147d67fe42dbd4cb5",
    "url": "https://api.github.com/users/ianlandsman",
    "html_url": "https://github.com/ianlandsman",
    "followers_url": "https://api.github.com/users/ianlandsman/followers",
    "following_url": "https://api.github.com/users/ianlandsman/following{/other_user}",
    "gists_url": "https://api.github.com/users/ianlandsman/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/ianlandsman/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/ianlandsman/subscriptions",
    "organizations_url": "https://api.github.com/users/ianlandsman/orgs",
    "repos_url": "https://api.github.com/users/ianlandsman/repos",
    "events_url": "https://api.github.com/users/ianlandsman/events{/privacy}",
    "received_events_url": "https://api.github.com/users/ianlandsman/received_events",
    "type": "User",
    "contributions": 1
  },
  {
    "login": "ashernevins",
    "id": 876802,
    "avatar_url": "https://0.gravatar.com/avatar/c1233c3f5698f2f8389f17a3b3eda7b6?d=https%3A%2F%2Fidenticons.github.com%2F9e48b1c1182b7c5f4292b5d9164084f4.png",
    "gravatar_id": "c1233c3f5698f2f8389f17a3b3eda7b6",
    "url": "https://api.github.com/users/ashernevins",
    "html_url": "https://github.com/ashernevins",
    "followers_url": "https://api.github.com/users/ashernevins/followers",
    "following_url": "https://api.github.com/users/ashernevins/following{/other_user}",
    "gists_url": "https://api.github.com/users/ashernevins/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/ashernevins/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/ashernevins/subscriptions",
    "organizations_url": "https://api.github.com/users/ashernevins/orgs",
    "repos_url": "https://api.github.com/users/ashernevins/repos",
    "events_url": "https://api.github.com/users/ashernevins/events{/privacy}",
    "received_events_url": "https://api.github.com/users/ashernevins/received_events",
    "type": "User",
    "contributions": 1
  }
]
EOF;

    return json_decode($json);
        $json = file_get_contents('https://api.github.com/repos/LaravelIO/laravel-io/contributors');

        if (empty($json)) return [];

        return json_decode($json);
    }
}