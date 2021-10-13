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
        $this->error('errors.fields');

        parent::failedValidation($validator);
    }
}
