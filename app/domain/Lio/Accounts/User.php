<?php namespace Lio\Accounts;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    const STATE_ACTIVE  = 1;
    const STATE_BLOCKED = 2;

    protected $table  = 'users';
    protected $hidden = ['password'];

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

    // Getters / Setters
    public function SetPasswordAttribute($value)
    {
        $this->password = \Hash::make($value);
    }
}