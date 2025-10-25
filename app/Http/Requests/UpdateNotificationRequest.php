<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('notification') ? $this->route('notification')->id : null;

        return [
            'recipient_type' => 'sometimes|required|string|max:50',
            'recipient_id' => 'sometimes|required|integer',
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
