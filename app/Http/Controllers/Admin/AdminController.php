<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Models\User;
use App\Queries\SearchUsers;
use Illuminate\Auth\Middleware\Authenticate;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function index()
    {
        if ($adminSearch = request('admin_search')) {
            $users = SearchUsers::get($adminSearch)->appends(['admin_search' => $adminSearch]);
        } else {
            $users = User::findAllPaginated();
        }

        return view('admin.overview', compact('users', 'adminSearch'));
    }
}
