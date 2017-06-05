<?php

namespace App\Http\Requests;

use App\User;
use App\Models\Thread;
use App\Validation\SpamRule;

class CreateReplyRequest extends Request
{
    public function rules()
    {
        return [
            'body' => 'required|'.SpamRule::NAME,
            'replyable_id' => 'required',
            'replyable_type' => 'required|in:'.Thread::TABLE,
        ];
    }

    public function replyAble()
    {
        return $this->findReplyAble($this->get('replyable_id'), $this->get('replyable_type'));
    }

    private function findReplyAble(int $id, string $type)
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
