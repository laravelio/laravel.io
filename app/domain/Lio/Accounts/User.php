<?php namespace Lio\Accounts;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

use Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    protected $table = 'users';
    protected $hidden = array('password');

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