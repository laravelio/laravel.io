<?php
namespace Lio\Http\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function rss()
    {
        return redirect()->home();
    }

    public function redirectToMainWebsite()
    {
        return redirect('http://laravel.io/');
    }
}
