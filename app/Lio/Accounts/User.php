<?php namespace Lio\Accounts;

use Carbon\Carbon;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Lio\Core\Entity;
use Eloquent;
use McCool\LaravelAutoPresenter\PresenterInterface;

class User extends Entity implements UserInterface, RemindableInterface, PresenterInterface
{
    use UserTrait, RemindableTrait, SoftDeletingTrait;

    const STATE_ACTIVE  = 1;
    const STATE_BLOCKED = 2;

    protected $table    = 'users';
    protected $hidden   = ['github_id', 'email', 'remember_token'];
    protected $fillable = ['email', 'name', 'github_url', 'github_id', 'image_url', 'is_banned', 'ip'];
    protected $dates    = ['deleted_at'];

    protected $validationRules = [
        'github_id' => 'unique:users,github_id,<id>',
        'email' => 'required|unique:users,email,<id>',
        'name' => 'required|unique:users,name,<id>',
    ];

    private $rolesCache;

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

    public function getRoles()
    {
        if ( ! isset($this->rolesCache)) {
            $this->rolesCache = $this->roles;
        }

        return $this->rolesCache;
    }

    public function isForumAdmin()
    {
        return $this->hasRole('manage_forum');
    }

    public function setRolesAttribute($roles)
    {
        $this->roles()->sync((array) $roles);
    }

    public function hasRole($roleName)
    {
        return $this->hasRoles($roleName);
    }

    public function hasRoles($roleNames = [])
    {
        $roleList = \App::make('Lio\Accounts\RoleRepository')->getRoleList();

        foreach ((array) $roleNames as $allowedRole) {
            // validate that the role exists
            if ( ! in_array($allowedRole, $roleList)) {
                throw new InvalidRoleException("Unidentified role: {$allowedRole}");
            }

            // validate that the user has the role
            if ( ! $this->roleCollectionHasRole($allowedRole)) {
                return false;
            }
        }

        return true;
    }

    private function roleCollectionHasRole($allowedRole)
    {
        $roles = $this->getRoles();

        if ( ! $roles) {
            return false;
        }

        foreach ($roles as $role) {
            if (strtolower($role->name) == strtolower($allowedRole)) {
                return true;
            }
        }

        return false;
    }

    // Forum
    public function forumPosts()
    {
        return $this->hasMany('Lio\Comments\Comment', 'author_id')->where('type', '=', \Lio\Comments\Comment::TYPE_FORUM)->orderBy('created_at', 'desc');
    }

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

    public function hasCreatedAThreadRecently()
    {
        $thread = $this->forumThreads()->first();

        if ($thread) {
            return $thread->created_at->gte(new Carbon('10 minutes ago'));
        }

        return false;
    }

    /**
     * Determine if the user has confirmed his email address already or not
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return (bool) $this->confirmed;
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Lio\Accounts\UserPresenter';
    }
}
