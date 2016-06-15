<?php

namespace Lio\Replies;

use Lio\Http\Requests\Request;

class UpdateReplyRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required',
        ];
    }
}
