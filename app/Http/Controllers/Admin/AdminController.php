<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Users\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::findAllPaginated();

        return view('admin.overview', compact('users'));
    }
}
