<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('student') ? $this->route('student')->id : null;

        return [
            'user_id' => 'nullable|exists:users,id',
            'mosque_id' => 'nullable|exists:mosques,id',
            'guardian_id' => 'nullable|exists:guardians,id',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
