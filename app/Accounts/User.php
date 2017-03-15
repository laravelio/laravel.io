<?php

namespace Lio\Accounts;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lio\Core\Entity;
use McCool\LaravelAutoPresenter\HasPresenter;

class User extends Entity implements AuthenticatableContract, CanResetPasswordContract, HasPresenter
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'name', 'github_url', 'github_id', 'image_url', 'is_banned', 'ip'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['github_id', 'email', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $validationRules = [
        'github_id' => 'unique:users,github_id,<id>',
        'email'     => 'required|email|unique:users,email,<id>',
        'name'      => 'required|alpha_num|unique:users,name,<id>',
    ];

    private $rolesCache;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRoles()
    {
        if (!isset($this->rolesCache)) {
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
        $roleList = app(RoleRepository::class)->getRoleList();

        foreach ((array) $roleNames as $allowedRole) {
            // validate that the role exists
            if (!$roleList->contains($allowedRole)) {
                throw new InvalidRoleException("Unidentified role: {$allowedRole}");
            }

            // validate that the user has the role
            if (!$this->roleCollectionHasRole($allowedRole)) {
                return false;
            }
        }

        return true;
    }

    private function roleCollectionHasRole($allowedRole)
    {
        $roles = $this->getRoles();

        if (!$roles) {
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
        if ($thread = $this->forumThreads()->first()) {
            return $thread->created_at->gte(new Carbon('10 minutes ago'));
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return (bool) $this->confirmed;
    }

    /**
     * @return bool
     */
    public function isBanned()
    {
        return (bool) $this->is_banned;
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return UserPresenter::class;
    }
}
