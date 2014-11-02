<?php
namespace Lio\Http\Filters;

use Illuminate\Auth\AuthManager;

class Banned
{
    /**
     * @var \Illuminate\Auth\Guard
     */
    private $auth;

    /**
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Logout the user if he's banned
     *
     * If the current authenticated user is banned and is trying
     * to access protected areas, log him out of the system.
     *
     * @return void
     */
    public function filter()
    {
        if ($this->auth->check() && $this->auth->user()->is_banned) {
            $this->auth->logout();
        }
    }
}
 