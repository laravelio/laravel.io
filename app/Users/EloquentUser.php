<?php

namespace Lio\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Lio\Eloquent\HasTimestamps;
use Lio\Replies\HasManyReplies;

final class EloquentUser extends Authenticatable implements User
{
    use HasManyReplies, HasTimestamps;

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
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function emailAddress(): string
    {
        return $this->email;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function githubUsername(): string
    {
        return $this->github_url;
    }
}
