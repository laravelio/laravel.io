<?php

namespace App\Http\Controllers\Settings;

use App\Actions\DisconnectGitHubAccount;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

final class GitHubAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function connect(): RedirectResponse
    {
        session()->put('settings.github.connect.intended', true);

        return redirect(route('login.github'));
    }

    public function disconnect(DisconnectGitHubAccount $disconnectGitHubAccount): RedirectResponse
    {
        $user = auth()->user();

        if (! $user->password) {
            $this->error('You must set a password before disconnecting your GitHub account, otherwise, you will not be able to log in again.');

            return redirect(route('settings.profile'));
        }

        $disconnectGitHubAccount($user);

        $this->success('Your GitHub account has been disconnected.');

        return redirect(route('settings.profile'));
    }
}
