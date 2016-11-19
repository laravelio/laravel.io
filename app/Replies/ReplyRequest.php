<?php

namespace App\Replies;

use App\Http\Requests\Request;

class ReplyRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required|spam',
        ];
    }
}
