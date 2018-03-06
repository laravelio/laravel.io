<?php

namespace App\Http\Requests;

use App\Validation\HttpImageRule;
use App\Validation\SpamRule;

class UpdateReplyRequest extends Request
{
    public function rules()
    {
        return [
            'body' => 'required|'.SpamRule::NAME.'|'.HttpImageRule::NAME,
        ];
    }

    public function body(): string
    {
        return $this->get('body');
    }
}
