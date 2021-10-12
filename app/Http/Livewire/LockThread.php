<?php

namespace App\Http\Livewire;

use App\Jobs\LockThread as LockThreadJob;
use App\Jobs\UnlockThread as UnlockThreadJob;
use App\Models\Thread;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class LockThread extends Component
{
    use DispatchesJobs;

    /** @var \App\Models\Thread */
    public $thread;

    public function mount(Thread $thread): void
    {
        $this->thread = $thread;
    }

    public function toggleLock(): void
    {
        if (Auth::guest()) {
            return;
        }

        if ($this->thread->isLockedBy(Auth::user())) {
            $this->dispatchNow(new UnlockThreadJob($this->thread));
        } else {
            $this->dispatchNow(new LockThreadJob(Auth::user(), $this->thread));
        }
    }

    public function render()
    {
        return view('livewire.lock-thread');
    }
}
