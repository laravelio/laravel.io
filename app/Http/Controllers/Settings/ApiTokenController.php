<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateApiTokenRequest;
use App\Http\Requests\DeleteApiTokenRequest;
use App\Jobs\CreateApiToken;
use App\Jobs\DeleteApiToken;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

class ApiTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function store(CreateApiTokenRequest $request): RedirectResponse
    {
        $plainTextToken = $this->dispatchSync(new CreateApiToken($request->user(), $request->name()));

        $this->success('API token created! Please copy the following token as it will not be shown again:');

        return redirect()->route('settings.profile')->with('api_token', $plainTextToken);
    }

    public function destroy(DeleteApiTokenRequest $request): RedirectResponse
    {
        $this->dispatchSync(new DeleteApiToken($request->user(), $request->id()));

        $this->success('API token successfully removed.');

        return redirect()->route('settings.profile');
    }
}
