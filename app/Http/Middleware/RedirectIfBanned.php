<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Helpers\SendsAlerts;

class RedirectIfBanned
{
    use SendsAlerts;

    public function handle($request, Closure $next, string $guard = null)
    {
        if (Auth::check() && Auth::user()->isBanned()) {
            $this->error('errors.banned');

            Auth::logout();

            return redirect()->home();
        }

        return $next($request);
    }
}
