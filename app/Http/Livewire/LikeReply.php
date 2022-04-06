<?php

namespace App\Http\Livewire;

use App\Jobs\LikeReply as LikeReplyJob;
use App\Jobs\UnlikeReply as UnlikeReplyJob;
use App\Models\Reply;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class LikeReply extends Component
{
    use DispatchesJobs;

    /** @var \App\Models\Reply */
    public $reply;

    public function mount(Reply $reply): void
    {
        $this->reply = $reply;
    }

    public function toggleLike(): void
    {
        if (Auth::guest()) {
            return;
        }

        if ($this->reply->isLikedBy(Auth::user())) {
            $this->dispatchSync(new UnlikeReplyJob($this->reply, Auth::user()));
        } else {
            $this->dispatchSync(new LikeReplyJob($this->reply, Auth::user()));
        }
    }
}
