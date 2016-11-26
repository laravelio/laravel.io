<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function show()
    {
        return view('home');
    }

    public function redirectToMainWebsite()
    {
        return redirect('http://laravel.io/', 301);
    }
}
