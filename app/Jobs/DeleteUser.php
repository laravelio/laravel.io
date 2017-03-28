<?php

namespace App\Jobs;

use App\Replies\Reply;
use App\Users\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\SerializesModels;

class DeleteUser
{
    use DispatchesJobs, SerializesModels;

    /**
     * @var \App\Users\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->deleteUserThreads();

        Reply::deleteByAuthor($this->user);

        $this->user->delete();
    }

    /**
     * @todo Perhaps solve this differently
     */
    private function deleteUserThreads()
    {
        foreach ($this->user->threads() as $thread) {
            $this->dispatchNow(new DeleteThread($thread));
        }
    }
}
