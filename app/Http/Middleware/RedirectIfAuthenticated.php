<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->home();
        }

        return $next($request);
    }
}
