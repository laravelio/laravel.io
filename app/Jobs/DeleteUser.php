<?php

namespace App\Jobs;

use App\Models\Reply;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DeleteUser
{
    use DispatchesJobs;

    /**
     * @var \App\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->deleteUserThreads();
        $this->deleteUserReplies();

        $this->user->delete();
    }

    /**
     * @todo Perhaps solve this differently
     */
    private function deleteUserThreads(): void
    {
        foreach ($this->user->threads() as $thread) {
            $this->dispatchNow(new DeleteThread($thread));
        }
    }

    private function deleteUserReplies(): void
    {
        Reply::deleteByAuthor($this->user);
    }
}
