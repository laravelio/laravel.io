<?php
namespace Lio\Http\Controllers;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->action('Forum\ForumThreadsController@getIndex');
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
