<?php namespace Controllers;

class Oauth extends Base
{
    public function getIndex()
    {
        if ( ! Input::has('code')) {
            return Redirect::to((string) GitHub::getAuthorizationUri());
        }

        $code = Input::get('code');
        Log::info('oauth received: ' . $code);

        GitHub::requestAccessToken($code);
        $result = json_decode(GitHub::request('user/emails'), true);
        Log::info('The first email on your github account is ' . $result[0]);
    }
}