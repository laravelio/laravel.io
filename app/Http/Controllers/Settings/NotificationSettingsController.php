<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveNotificationSettingsRequest;
use App\Jobs\SaveNotificationSettings;
use Illuminate\Auth\Middleware\Authenticate;

class NotificationSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function store(SaveNotificationSettingsRequest $request)
    {
        $this->dispatchSync(new SaveNotificationSettings($user = $request->user(), (array) $request->validated('notification_types')));
        return redirect()->route('settings.profile');
    }
}
