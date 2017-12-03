<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeReplyTwice;
use App\Models\Reply;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\QueryException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LikeReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Reply $reply
     * @param \App\User $user
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
     * @throws \App\Exceptions\CannotLikeReplyTwice
     */
    public function handle()
    {
        try {
            $this->reply->likedBy($this->user);
        } catch (QueryException $exception) {
            throw new CannotLikeReplyTwice('Sorry, you cannot like a reply twice');
        }
    }
}
