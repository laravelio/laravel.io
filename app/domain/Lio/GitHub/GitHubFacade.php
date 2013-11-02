<?php namespace Lio\GitHub;

use Illuminate\Support\Facades\Facade;

class GitHubFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'github'; }

    public static function getUserDataByCode($code)
    {
        // retreive the oauth token
        $oauthTokenObject = static::requestAccessToken($code);

        // acquire the relevant user information
        $githubData = json_decode(static::request('user'), true);
        list($githubEmail) = json_decode(static::request('user/emails'), true);
        $githubData['email'] = $githubEmail;

        return $githubData;
    }
}