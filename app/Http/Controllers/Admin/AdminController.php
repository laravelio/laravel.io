<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Users\UserRepository;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(UserRepository $users)
    {
        $users = $users->findAllPaginated();

        return view('admin.overview', compact('users'));
    }
}
