<?php
namespace Lio\Http\Controllers;

use Lio\Users\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'profile']);
    }

    public function dashboard()
    {
        return view('users.dashboard');
    }

    public function profile(User $user)
    {
        return view('users.profile', compact('user'));
    }
}
