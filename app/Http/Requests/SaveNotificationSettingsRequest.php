<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNotificationSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
          'notification_types.*' => 'string'
        ];
    }
}
