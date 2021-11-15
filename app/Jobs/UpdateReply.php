<?php

namespace App\Jobs;

use App\Http\Requests\UpdateReplyRequest;
use App\Models\Reply;

final class UpdateReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var array
     */
    private $attributes;

    public function __construct(Reply $reply, UpdateReplyRequest $request)
    {
        $this->reply = $reply;
        $this->attributes = [
            'body' => $request->body,
            'updated_by' => $request->user()->id,
        ];
    }

    public function handle()
    {
        $this->reply->update($this->attributes);
    }
}
