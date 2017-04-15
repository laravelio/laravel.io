<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\SendsAlerts;

abstract class Request extends FormRequest
{
    use SendsAlerts;

    public function authorize()
    {
        // Allow all requests and handle authorization in controllers.
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->error('errors.fields');

        parent::failedValidation($validator);
    }
}
