<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Queries\SearchThreads;

class ThreadsController extends Controller
{
    public function index()
    {
        if ($adminSearch = request('admin_search')) {
            $threads = SearchThreads::get($adminSearch)->appends(['admin_search' => $adminSearch]);
        } else {
            $threads = Thread::orderByDesc('updated_at')->paginate();
        }

        return view('admin.threads', compact('threads', 'adminSearch'));
    }
}
