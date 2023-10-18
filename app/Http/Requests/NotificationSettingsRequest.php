<?php

namespace App\Http\Requests;

use App\Enums\NotificationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'allowed_notifications.*' => Rule::enum(NotificationType::class),
        ];
    }
}
