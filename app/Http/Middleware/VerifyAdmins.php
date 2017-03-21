<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyAdmins
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (! Auth::guard($guard)->user()->isAdmin()) {
            throw new HttpException(403, 'Forbidden');
        }

        return $next($request);
    }
}
