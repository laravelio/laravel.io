<?php namespace Lio\Accounts;

use Lio\Core\EloquentBaseRepository;
use GitHub;

class UserRepository extends EloquentBaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getByOauthCode($code)
    {
        // retreive the oauth token
        $oauthTokenObject = GitHub::requestAccessToken($code);

        // acquire the relevant user information
        $githubUser = json_decode(GitHub::request('user'), true);
        list($githubEmail) = json_decode(GitHub::request('user/emails'), true);
        $githubUser['email'] = $githubEmail;

        // create or update / the user
        $user = User::where('github_id', '=', $githubUser['id'])->first();

        if ( ! $user) {
            $user = new User;
        }

        $user->fill([
            'name'               => $githubUser['name'],
            'email'              => $githubUser['email'],
            'github_id'          => $githubUser['id'],
            'github_url'         => $githubUser['html_url'],
        ]);

        $user->save();

        return $user;
    }
}
