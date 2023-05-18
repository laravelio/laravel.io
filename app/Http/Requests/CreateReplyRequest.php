<?php

namespace App\Http\Requests;

use App\Contracts\ReplyAble;
use App\Models\Thread;
use App\Models\User;
use App\Rules\HttpImageRule;
use App\Rules\InvalidMentionRule;

class CreateReplyRequest extends Request
{
    public function rules()
    {
        return [
            'body' => ['required', new HttpImageRule(), new InvalidMentionRule()],
            'replyable_id' => 'required',
            'replyable_type' => 'required|in:'.Thread::TABLE,
        ];
    }

    public function replyAble(): ReplyAble
    {
        $replyable = $this->findReplyAble($this->get('replyable_id'), $this->get('replyable_type'));

        abort_if(
            $replyable->isConversationOld(),
            403,
            'Last activity is too old',
        );

        return $replyable;
    }

    private function findReplyAble(int $id, string $type): ReplyAble
    {
        return match ($type) {
            Thread::TABLE => Thread::find($id),
        };

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
