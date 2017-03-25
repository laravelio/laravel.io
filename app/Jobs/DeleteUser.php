<?php

namespace App\Jobs;

use App\Forum\ThreadRepository;
use App\Replies\ReplyRepository;
use App\Users\User;
use Illuminate\Queue\SerializesModels;

class DeleteUser
{
    use SerializesModels;

    /**
     * @var \App\Users\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(ThreadRepository $threads, ReplyRepository $replies)
    {
        $threads->deleteByAuthor($this->user);
        $replies->deleteByAuthor($this->user);

        $this->user->delete();
    }
}
