<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;

final class UpdateReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var User
     */
    private $updatedBy;

    /**
     * @var string
     */
    private $body;

    public function __construct(Reply $reply, User $updatedBy, string $body)
    {
        $this->reply = $reply;
        $this->updatedBy = $updatedBy;
        $this->body = $body;
    }

    public function handle()
    {
        $this->reply->update([
            'updated_by' => $this->updatedBy->id,
            'body' => $this->body,
        ]);
    }
}
