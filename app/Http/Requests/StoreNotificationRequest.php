<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipient_type' => 'required|string|max:50',
            'recipient_id' => 'required|integer',
            'channel' => 'nullable|string|max:50',
            'template_id' => 'nullable|exists:message_templates,id',
            'payload' => 'nullable|array',
            'status' => 'nullable|string|max:50',
            'sent_at' => 'nullable|date',
            'error' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
