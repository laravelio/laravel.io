<?php

namespace Lio\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\Store as Session;

class EmailConfirmed
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @var \Illuminate\Session\Store
     */
    private $session;

    /**
     * Create a new filter instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param \Illuminate\Session\Store        $session
     */
    public function __construct(Guard $auth, Session $session)
    {
        $this->auth = $auth;
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->user()->isConfirmed()) {
            // Don't let people who haven't confirmed their email use the authed sections on the website.
            $this->session->put('error', 'Please confirm your email address  ('.$this->auth->user()->email.') before you try to use this section.
            <a style="color:#fff" href="'.route('auth.reconfirm').'">Re-send confirmation email.</a>
            <a href="'.route('user.settings', $this->auth->user()->name).'" style="color:#eee;">Change e-mail address.</a>');

            return redirect()->home();
        }

        return $next($request);
    }
}
