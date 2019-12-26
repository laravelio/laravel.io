<?php

namespace App\Http\Livewire;

use App\Jobs\LikeThread as LikeThreadJob;
use App\Jobs\UnlikeThread as UnlikeThreadJob;
use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeThread extends Component
{
    use DispatchesJobs;

    public $likes;

    public $threadId;

    public function mount(Thread $thread): void
    {
        $this->threadId = $thread->id;
        $this->likes = $this->thread->likes_count;
    }

    public function getThreadProperty(): Thread
    {
        return Thread::findOrFail($this->threadId);
    }

    public function getUserProperty(): ?User
    {
        return Auth::user();
    }

    public function toggleLike(): void
    {
        if (! $this->user) {
            return;
        }

        if ($this->thread->isLikedBy($this->user)) {
            $this->dispatchNow(new UnlikeThreadJob($this->thread, $this->user));
        } else {
            $this->dispatchNow(new LikeThreadJob($this->thread, $this->user));
        }

        $this->likes = $this->thread->likes_count;
    }
}
