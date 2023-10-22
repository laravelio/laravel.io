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

        $this->success('settings.api_token.created');

        return redirect()->route('settings.profile')->with('api_token', $plainTextToken);
    }

    public function destroy(DeleteApiTokenRequest $request): RedirectResponse
    {
        $this->dispatchSync(new DeleteApiToken($request->user(), $request->id()));

        $this->success('settings.api_token.deleted');

        return redirect()->route('settings.profile');
    }
}
