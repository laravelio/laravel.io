<?php

namespace App\Http\Requests;

use App\Concerns\SendsAlerts;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    use SendsAlerts;

    protected function failedValidation(Validator $validator)
    {
        $this->error('Something went wrong. Please review the fields below.');

        parent::failedValidation($validator);
    }
}
