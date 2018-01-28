<?php

namespace App\Jobs;

use App\Models\Reply;

final class UpdateReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var string
     */
    private $body;

    public function __construct(Reply $reply, string $body)
    {
        $this->reply = $reply;
        $this->body = $body;
    }

    public function handle()
    {
        $this->reply->update(['body' => $this->body]);
    }
}
