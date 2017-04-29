<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class HomeController extends Controller
{
    public function show()
    {
        return view('home', ['threads' => Thread::latest()]);
    }
}
