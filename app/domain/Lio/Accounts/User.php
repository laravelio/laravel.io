<?php namespace Lio\Accounts;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use GitHub;
use Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    const STATE_ACTIVE  = 1;
    const STATE_BLOCKED = 2;

    protected $table    = 'users';
    protected $hidden   = ['github_id'];
    protected $fillable = ['email', 'name', 'github_url', 'github_id'];

    public function roles()
    {
        return $this->belongsToMany('Lio\Accounts\Role');
    }

    // UserInterface
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    // RemindableInterface
    public function getReminderEmail()
    {
        return $this->email;
    }

    // Oauth
    public static function getByOauthCode($code)
    {
        // retreive the oauth token
        $oauthTokenObject = GitHub::requestAccessToken($code);

        // acquire the relevant user information
        $githubUser = json_decode(GitHub::request('user'), true);
        list($githubEmail) = json_decode(GitHub::request('user/emails'), true);
        $githubUser['email'] = $githubEmail;

        // create or update / the user
        $user = static::where('github_id', '=', $githubUser['id'])->first();

        if ( ! $user) {
            $user = new static;
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