<?php
namespace Lio\Http\Controllers;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function home()
    {
        return 'Where it starts';
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
