<?php
namespace Lio\Http\Controllers;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
