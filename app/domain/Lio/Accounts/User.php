<?php namespace Lio\Accounts;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Lio\Core\EloquentBaseModel;
use GitHub;
use Eloquent;

class User extends EloquentBaseModel implements UserInterface, RemindableInterface
{
    const STATE_ACTIVE  = 1;
    const STATE_BLOCKED = 2;

    protected $table      = 'users';
    protected $hidden     = ['github_id'];
    protected $fillable   = ['email', 'name', 'github_url', 'github_id', 'image_url', 'is_banned'];
    protected $softDelete = true;

    public $presenter = 'Lio\Accounts\UserPresenter';

    protected $validationRules = [];

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

    // Forum
    public function forumPosts()
    {
        return $this->hasMany('Lio\Comments\Comment', 'author_id')->where('type', '=', \Lio\Comments\Comment::TYPE_FORUM)->orderBy('created_at', 'desc');
    }

    public function forumThreads()
    {
        return $this->hasMany('Lio\Comments\Comment', 'author_id')->whereNull('parent_id')->where('type', '=', \Lio\Comments\Comment::TYPE_FORUM)->orderBy('created_at', 'desc');
    }

    public function forumReplies()
    {
        return $this->hasMany('Lio\Comments\Comment', 'author_id')->whereNotNull('parent_id')->where('type', '=', \Lio\Comments\Comment::TYPE_FORUM)->orderBy('created_at', 'desc');
    }

    public function mostRecentFiveForumPosts()
    {
        return $this->forumPosts()->take(5);
    }
}