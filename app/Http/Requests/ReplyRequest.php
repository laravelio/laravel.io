<?php

namespace App\Http\Requests;

use App\Models\Thread;
use App\User;
use Auth;

class ReplyRequest extends Request
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
