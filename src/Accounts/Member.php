<?php namespace Lio\Accounts;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Lio\Events\EventGenerator;

class Member extends Model implements UserInterface
{
    use EventGenerator;

    protected $table = 'members';
    protected $guarded = [];
    protected $softDelete = true;

    const STATE_ACTIVE = 1;
    const STATE_BANNED = 2;

    public static function register($name, $email, $githubUrl, $githubId, $imageUrl)
    {
        $member = new static([
            'name' => $name,
            'email' => $email,
            'github_url' => $githubUrl,
            'github_id' => $githubId,
            'image_url' => $imageUrl,
        ]);

        return $member;
    }

    // Roles
    public function roles()
    {
        return $this->belongsToMany('Lio\Accounts\Role');
    }

    public function isForumAdmin()
    {
        return $this->hasRole('manage_forum');
    }

    public function isArticleAdmin()
    {
        return $this->hasRole('manage_articles');
    }

    public function isUserAdmin()
    {
        return $this->hasRole('manage_users');
    }

    public function hasRole($roleName)
    {
        return $this->hasRoles($roleName);
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

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function bannedBy(Member $moderator)
    {
        $this->is_banned = 1;
    }
}
