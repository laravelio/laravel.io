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

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function githubUsername()
    {
        return $this->github_url;
    }
}
