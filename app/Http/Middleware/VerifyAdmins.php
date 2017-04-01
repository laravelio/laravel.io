<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyAdmins
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (! Auth::guard($guard)->user()->can('admin', User::class)) {
            throw new HttpException(403, 'Forbidden');
        }

        return $next($request);
    }
}
