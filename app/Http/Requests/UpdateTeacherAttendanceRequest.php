<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('teacher_attendance') ? $this->route('teacher_attendance')->id : null;

        return [
            'circle_id' => 'sometimes|required|exists:circles,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'date_g' => 'nullable|date',
            'date_h' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
