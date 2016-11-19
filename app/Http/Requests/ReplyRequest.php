<?php

namespace App\Http\Requests;

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
}
