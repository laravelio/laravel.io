<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Helpers\SendsAlerts;

class RedirectIfUnconfirmed
{
    use SendsAlerts;

    public function handle($request, Closure $next, string $guard = null)
    {
        if (Auth::user()->isUnconfirmed()) {
            $this->error('errors.unconfirmed');

            return redirect()->home();
        }

        return $next($request);
    }
}
