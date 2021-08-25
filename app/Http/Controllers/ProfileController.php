<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->latestArticles(3);

        return view('users.profile', compact('user', 'articles'));
    }
}
