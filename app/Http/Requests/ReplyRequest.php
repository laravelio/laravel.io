<?php

namespace App\Http\Requests;

use App\Forum\Thread;
use App\Replies\ReplyData;
use App\Replies\ReplyAble;
use App\User;
use Auth;

class ReplyRequest extends Request implements ReplyData
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'body' => 'required|spam',
        ];
    }

    public function replyAble(): ReplyAble
    {
        return $this->findReplyAble($this->get('replyable_id'), $this->get('replyable_type'));
    }

    private function findReplyAble(int $id, string $type): ReplyAble
    {
        switch ($type) {
            case Thread::TABLE:
                return Thread::find($id);
        }

        abort(404);
    }

    public function author(): User
    {
        return $this->user();
    }

    public function body(): string
    {
        return $this->get('body');
    }
}
