<?php

namespace Lio\Forum;

use Lio\Http\Requests\Request;

class ThreadRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required',
            'body' => 'required',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
