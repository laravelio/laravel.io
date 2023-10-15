<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Queries\SearchReplies;

class RepliesController extends Controller
{
    public function index()
    {
        if ($adminSearch = request('admin_search')) {
            $replies = SearchReplies::get($adminSearch)->appends(['admin_search' => $adminSearch]);
        } else {
            $replies = Reply::with('replyAbleRelation')->orderByDesc('updated_at')->paginate();
        }

        return view('admin.replies', compact('replies', 'adminSearch'));
    }
}
