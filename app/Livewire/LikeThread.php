<?php

namespace App\Livewire;

use App\Jobs\LikeThread as LikeThreadJob;
use App\Jobs\UnlikeThread as UnlikeThreadJob;
use App\Models\Thread;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class LikeThread extends Component
{
    /** @var \App\Models\Thread */
    public $thread;

    public function mount(Thread $thread): void
    {
        $this->thread = $thread;
    }

    public function toggleLike(): void
    {
        if (Auth::guest()) {
            return;
        }

        if ($this->thread->isLikedBy(Auth::user())) {
            dispatch_sync(new UnlikeThreadJob($this->thread, Auth::user()));
        } else {
            dispatch_sync(new LikeThreadJob($this->thread, Auth::user()));
        }
    }
}
