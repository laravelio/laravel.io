<?php

namespace App\Http\Middleware;

use App\Alerts\SendsAlerts;
use Auth;
use Closure;

class CheckConfirmation
{
    use SendsAlerts;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next, string $guard = null)
    {
        if (Auth::check() && Auth::user()->isUnconfirmed()) {
            $this->error('errors.unconfirmed');
        }

        return $next($request);
    }
}
