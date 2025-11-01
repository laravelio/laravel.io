<?php

namespace App\Livewire;

use App\Concerns\SendsAlerts;
use App\Jobs\UpdateUserIdenticonStatus;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Livewire\Component;

final class RefreshAvatar extends Component
{
    use SendsAlerts;

    public $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function refresh(): void
    {
        if (! $this->user->hasConnectedGitHubAccount()) {
            $this->error('You need to connect your GitHub account to refresh your avatar.');

            $this->redirectRoute('settings.profile');

            return;
        }

        // Rate limiting: 1 request per 1 minute per user.
        $key = 'avatar-refresh:'.$this->user->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->error('Please wait 1 minute before refreshing your avatar again.');

            $this->redirectRoute('settings.profile');

            return;
        }

        // Record this attempt for 1 minute.
        RateLimiter::hit($key, 60);

        UpdateUserIdenticonStatus::dispatchSync($this->user);

        $this->success('Avatar refreshed successfully!');

        $this->redirectRoute('settings.profile');
    }

    public function render(): View
    {
        return view('livewire.refresh-avatar');
    }
}
