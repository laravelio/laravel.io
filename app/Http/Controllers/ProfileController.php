<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateUserIdenticonStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ProfileController extends Controller
{
    public function show(Request $request, ?User $user = null)
    {
        if ($user) {
            $articles = $user->latestArticles(3);

            return view('users.profile', compact('user', 'articles'));
        }

        if ($request->user()) {
            return redirect()->route('profile', $request->user()->username());
        }

        abort(404);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();

        if (! $user->hasConnectedGitHubAccount()) {
            return back()->with('error', 'You need to connect your GitHub account to refresh your avatar.');
        }

        // Rate limiting: 1 request per 1 minute per user
        $key = 'avatar-refresh:'.$user->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return back()->with('error', 'Please wait 1 minute(s) before refreshing your avatar again.');
        }

        // Record this attempt for 1 minute.
        RateLimiter::hit($key, 60);

        UpdateUserIdenticonStatus::dispatchSync($user);

        return back()->with('success', 'Avatar refresh queued! Your profile image will be updated shortly.');
    }
}
