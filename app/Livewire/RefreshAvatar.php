<?php

namespace App\Livewire;

use App\Jobs\UpdateUserIdenticonStatus;
use App\Concerns\SendsAlerts;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

final class RefreshAvatar extends Component
{
    use SendsAlerts;
    public $user;

    public function mount($user): void
    {
        $this->user = $user;
    }

    public function refresh()
    {
        if (! $this->user->hasConnectedGitHubAccount()) {
            $this->error('You need to connect your GitHub account to refresh your avatar.');
            return Redirect::route('settings.profile');
        }

        // Rate limiting: 1 request per 1 minute per user
        $key = 'avatar-refresh:' . $this->user->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->error('Please wait 1 minute before refreshing your avatar again.');
            return Redirect::route('settings.profile');
        }

        // Record this attempt for 1 minute.
        RateLimiter::hit($key, 60);

        UpdateUserIdenticonStatus::dispatchSync($this->user);

        $this->success('Avatar refreshed successfully!');
    return Redirect::route('settings.profile');
    }

    public function render()
    {
        return view('livewire.refresh-avatar');
    }
}
