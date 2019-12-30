<?php

namespace App\Http\Livewire;

use App\Jobs\LikeReply as LikeReplyJob;
use App\Jobs\UnlikeReply as UnlikeReplyJob;
use App\Models\Reply;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeReply extends Component
{
    use DispatchesJobs;

    public $likes;

    public $replyId;

    public function mount(Reply $reply): void
    {
        $this->replyId = $reply->id;
        $this->likes = $this->reply->likes_count;
    }

    public function getReplyProperty(): Reply
    {
        return Reply::findOrFail($this->replyId);
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

        if ($this->reply->isLikedBy($this->user)) {
            $this->dispatchNow(new UnlikeReplyJob($this->reply, $this->user));
        } else {
            $this->dispatchNow(new LikeReplyJob($this->reply, $this->user));
        }

        $this->likes = $this->reply->likes_count;
    }
}
