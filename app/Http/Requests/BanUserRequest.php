<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\HttpImageRule;
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
