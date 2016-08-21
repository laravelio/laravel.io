<?php

namespace Lio\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Lio\Alerts\SendsAlerts;

abstract class Request extends FormRequest
{
    use SendsAlerts;

    protected function failedValidation(Validator $validator)
    {
        $this->error('errors.fields');

        parent::failedValidation($validator);
    }
}
