<?php

namespace App\Jobs;

use App\Http\Requests\ReplyRequest;
use App\Models\Reply;

class CreateReply
{
    /**
     * @var \App\Http\Requests\ReplyRequest
     */
    public $request;

    public function __construct(ReplyRequest $request)
    {
        $this->request = $request;
    }

    public function handle(): Reply
    {
        $reply = new Reply;
        $reply->body = $this->request->body();
        $reply->author_id = $this->request->author()->id();
        $reply->ip = $this->request->ip();

        $this->request->replyAble()->repliesRelation()->save($reply);

        $reply->save();

        return $reply;
    }
}
