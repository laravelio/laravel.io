<?php

namespace App\Http\Middleware;

use App\Alerts\SendsAlerts;
use Auth;
use Closure;

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
