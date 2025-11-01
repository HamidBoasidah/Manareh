<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $userId = $student ? $student->user_id : null;

        return [
            'user_id' => ['prohibited'],
            'user' => ['nullable', 'array'],
            'user.name' => ['sometimes', 'string', 'max:255'],
            'user.email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'user.password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'user.address' => ['sometimes', 'nullable', 'string', 'max:255'],
            'user.phone_number' => ['sometimes', 'nullable', 'regex:/^\d{9}$/'],
            'user.whatsapp_number' => ['sometimes', 'nullable', 'regex:/^\d{9}$/'],
            'user.is_active' => ['sometimes', 'boolean'],
            'user.updated_by' => ['sometimes', 'nullable', 'exists:users,id'],
            'user.attachment' => ['sometimes', 'nullable', 'image', 'max:2048'],
            'mosque_id' => ['nullable', 'exists:mosques,id'],
            'guardian_id' => ['nullable', 'exists:guardians,id'],
            'birth_date' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
