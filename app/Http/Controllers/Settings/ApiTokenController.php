<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateApiTokenRequest;
use App\Http\Requests\DeleteApiTokenRequest;
use App\Jobs\CreateApiToken;
use App\Jobs\DeleteApiToken;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class ApiTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function store(CreateApiTokenRequest $request)
    {
        $this->dispatchSync(new CreateApiToken(Auth::user(), $request->name()));

        $token = Sanctum::$personalAccessTokenModel::whereName($request->name())->first();

        $this->success('settings.api_token.created');

        return redirect()->route('settings.profile')->with('api_token', $token->plainTextToken);
    }

    public function destroy(DeleteApiTokenRequest $request)
    {
        $this->dispatchSync(new DeleteApiToken(Auth::user(), $request->id()));

        $this->success('settings.api_token.deleted');

        return redirect()->route('settings.profile');
    }
}
