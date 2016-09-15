<?php

namespace App\Http\Middleware;

use App\Alerts\SendsAlerts;
use Auth;
use Closure;

class RedirectIfUnverified
{
    use SendsAlerts;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next, string $guard = null)
    {
        if (Auth::user()->isUnverified()) {
            $this->error('errors.unverified');

            return redirect()->home();
        }

        return $next($request);
    }
}
