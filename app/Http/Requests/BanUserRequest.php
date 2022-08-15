<?php

namespace App\Http\Requests;

use Illuminate\Http\Concerns\InteractsWithInput;

class BanUserRequest extends Request
{
    use InteractsWithInput;

    public function rules()
    {
        return [
            'msg' => ['max:100'],
        ];
    } 
}
