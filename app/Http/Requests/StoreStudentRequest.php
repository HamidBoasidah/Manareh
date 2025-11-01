<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->input('user_id');

        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'user' => ['nullable', 'array'],
            'user.name' => ['required_without:user_id', 'string', 'max:255'],
            'user.email' => [
                'required_without:user_id',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'user.password' => ['required_without:user_id', 'string', 'min:8', 'confirmed'],
            'user.address' => ['nullable', 'string', 'max:255'],
            'user.phone_number' => ['nullable', 'regex:/^\d{9}$/'],
            'user.whatsapp_number' => ['nullable', 'regex:/^\d{9}$/'],
            'user.is_active' => ['nullable', 'boolean'],
            'user.created_by' => ['nullable', 'exists:users,id'],
            'user.updated_by' => ['nullable', 'exists:users,id'],
            'user.attachment' => ['nullable', 'image', 'max:2048'],
            'mosque_id' => ['nullable', 'exists:mosques,id'],
            'guardian_id' => ['nullable', 'exists:guardians,id'],
            'birth_date' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
