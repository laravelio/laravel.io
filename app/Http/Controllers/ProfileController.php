<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user, Request $request)
    {
        abort_unless($user = $user->exists ? $user : $request->user(), 404);
        // $user = $user->exists ? $user : $request->user();

        // if (! $user) {
        //     abort(404);
        // }

        return view('users.profile', compact('user'));
    }
}
