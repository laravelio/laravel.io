<?php

namespace App\Http\Requests;

use App\Models\ReplyAble;
use App\Models\Thread;
use App\Rules\HttpImageRule;
use App\User;

class CreateReplyRequest extends Request
{
    public function rules()
    {
        return [
            'body' => ['required', new HttpImageRule()],
            'replyable_id' => 'required',
            'replyable_type' => 'required|in:' . Thread::TABLE,
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
