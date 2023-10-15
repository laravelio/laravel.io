<?php

namespace App\Http\Requests;

use App\Rules\HttpImageRule;
use App\Rules\InvalidMentionRule;

class UpdateReplyRequest extends Request
{
    public function rules(): array
    {
        return [
            'body' => ['required', new HttpImageRule(), new InvalidMentionRule()],
        ];
    }

    public function body(): string
    {
        return $this->get('body');
    }
}
