<?php

use App\Forum\Thread;
use App\Helpers\BuildsModels;
use App\Replies\Reply;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    use BuildsModels;

    public function run()
    {
        $this->create(Thread::class, ['author_id' => 1], 50);

        $this->create(Reply::class, ['author_id' => 1, 'replyable_id' => 1]);
        $this->create(Reply::class, ['author_id' => 1, 'replyable_id' => 1]);
        $this->create(Reply::class, ['author_id' => 1, 'replyable_id' => 2]);
    }
}
