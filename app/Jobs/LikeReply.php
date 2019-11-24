<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeReplyMultipleTimes;
use App\User;
use App\Models\Reply;
use Illuminate\Database\QueryException;

class LikeReply
{
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
        if($this->reply->isLikedBy($this->user)) {
            throw new CannotLikeReplyMultipleTimes();
        }

        $this->reply->likedBy($this->user);
    }
}
