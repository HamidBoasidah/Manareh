<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'circle_id' => 'required|exists:circles,id',
            'student_id' => 'required|exists:students,id',
            'status' => 'nullable|string|max:50',
            'joined_at' => 'nullable|date',
            'left_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
