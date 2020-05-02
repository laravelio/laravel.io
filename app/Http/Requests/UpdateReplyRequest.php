<?php

namespace App\Http\Requests;

use App\Rules\HttpImageRule;

class UpdateReplyRequest extends Request
{
    public function rules()
    {
        return [
            'body' => ['required', new HttpImageRule()],
        ];
    }

    public function body(): string
    {
        return $this->get('body');
    }
}
