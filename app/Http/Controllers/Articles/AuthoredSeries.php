<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfUnconfirmed;
use Illuminate\Http\Request;

class AuthoredSeries extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, RedirectIfUnconfirmed::class]);
    }

    public function __invoke(Request $request)
    {
        return view('users.series', [
            'series' => $request->user()->series
        ]);
    }
}
