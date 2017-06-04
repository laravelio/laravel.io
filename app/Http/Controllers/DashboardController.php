<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Middleware\Authenticate;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function show()
    {
        return view('users.dashboard');
    }
}
