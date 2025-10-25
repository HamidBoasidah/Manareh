<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('student_attendance') ? $this->route('student_attendance')->id : null;

        return [
            'circle_id' => 'sometimes|required|exists:circles,id',
            'student_id' => 'sometimes|required|exists:students,id',
            'date_g' => 'nullable|date',
            'date_h' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'reason' => 'nullable|string',
            'recorded_by' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
