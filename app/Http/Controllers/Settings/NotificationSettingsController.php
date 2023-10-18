<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationSettingsRequest;
use App\Jobs\SaveNotificationSettings;
use Illuminate\Auth\Middleware\Authenticate;

class NotificationSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function store(NotificationSettingsRequest $request)
    {
        $this->dispatchSync(new SaveNotificationSettings(
            $request->user(),
            (array) $request->validated('allowed_notifications')
        ));

        $this->success('settings.notifications.updated');

        return redirect()->route('settings.profile');
    }
}
