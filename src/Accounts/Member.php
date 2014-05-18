<?php namespace Lio\Accounts;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Events\MemberLoggedInThroughGithub;
use Lio\Events\EventGenerator;

class Member extends Model implements UserInterface
{
    use EventGenerator;

    protected $table = 'users';
    protected $guarded = [];
    protected $softDelete = true;
    public $presenter = 'Lio\Accounts\UserPresenter';

    const STATE_ACTIVE = 1;
    const STATE_BANNED = 2;

    public function login()
    {
        $this->raise(new MemberLoggedInThroughGithub($this));
    }

    // Articles
    public function articles()
    {
        return $this->hasMany('Lio\Articles\Article', 'author_id');
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

    // Notifications
    public function notifications()
    {
        $this->hasMany('Lio\Notifications\Notification', 'user_id');
    }

    // Forum
    public function forumThreads()
    {
        return $this->hasMany('Lio\Forum\Threads\Thread', 'author_id')->orderBy('created_at', 'desc');
    }

    public function forumReplies()
    {
        return $this->hasMany('Lio\Forum\Replies\Reply', 'author_id')->orderBy('created_at', 'desc');
    }

    public function mostRecentFiveForumPosts()
    {
        return $this->forumPosts()->take(5);
    }

    public function getLatestThreadsPaginated($max = 5)
    {
        return $this->forumThreads()->paginate($max);
    }

    public function getLatestRepliesPaginated($max = 5)
    {
        return $this->forumReplies()->with('thread')->paginate($max);
    }

    public function ban()
    {
        $this->is_banned = 1;
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
}
