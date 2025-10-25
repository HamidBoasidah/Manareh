<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('message_template') ? $this->route('message_template')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'code' => 'sometimes|required|string|max:255',
            'channel' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
