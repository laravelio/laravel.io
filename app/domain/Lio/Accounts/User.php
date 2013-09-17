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

    protected $rolesCache;

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
            if ( ! in_array($allowedRole, $roleList)) {
                throw new InvalidRoleException("Unidentified role: {$allowedRole}");
            }

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
}