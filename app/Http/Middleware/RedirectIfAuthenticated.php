<?php

namespace Lio\Http\Middleware;

use Auth;
use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next, string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->home();
        }

        return $next($request);
    }
}
