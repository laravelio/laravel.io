<?php
namespace Lio\Http\Controllers;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rss()
    {
        return redirect()->home();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToMainWebsite()
    {
        return redirect('http://laravel.io/');
    }
}
