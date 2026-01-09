<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, ?User $user = null)
    {
        if ($user) {
            $articles = $user->paginatedArticles(3);
            $threads = $user->paginatedThreads(5);
            $replies = $user->paginatedReplies(5);

            return view('users.profile', compact('user', 'articles', 'threads', 'replies'));
        }

        if ($request->user()) {
            return redirect()->route('profile', $request->user()->username());
        }

        abort(404);
    }
}
