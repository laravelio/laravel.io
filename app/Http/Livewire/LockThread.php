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

    /** @var \App\Models\User */
    public $locker;

    public function mount(Thread $thread): void
    {
        $this->thread = $thread;
        $this->locker = $thread->locker()?->username();
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
            $this->locker = Auth::user()->username;
        }
    }

    public function render()
    {
        return view('livewire.lock-thread');
    }
}
