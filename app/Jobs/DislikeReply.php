<?php

namespace App\Jobs;

use App\Models\Reply;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DislikeReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var \App\Jobs\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Reply $reply
     * @param \App\Jobs\User $user
     */
    public function __construct(Reply $reply, User $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->reply->dislikedBy($this->user);
    }
}
