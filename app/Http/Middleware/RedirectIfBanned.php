<?php

namespace App\Http\Middleware;

use App\Concerns\SendsAlerts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfBanned
{
    use SendsAlerts;

    public function handle(Request $request, Closure $next, string $guard = null): Response
    {
        if (Auth::check() && Auth::user()->isBanned()) {
            $this->error('errors.banned');

            Auth::logout();

            return redirect()->route('home');
        }

        return $next($request);
    }
}
