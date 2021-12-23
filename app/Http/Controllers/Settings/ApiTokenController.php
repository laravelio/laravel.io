<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteApiTokenRequest;
use App\Http\Requests\CreateApiTokenRequest;
use App\Jobs\CreateApiToken;
use App\Jobs\DeleteApiToken;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function store(CreateApiTokenRequest $request)
    {
        $this->dispatchSync(new CreateApiToken(Auth::user(), $request->name()));

        return redirect()->route('settings.profile');
    }

    public function destroy(DeleteApiTokenRequest $request)
    {
        $this->dispatchSync(new DeleteApiToken(Auth::user(), $request->id()));

        return redirect()->route('settings.profile');
    }
}
