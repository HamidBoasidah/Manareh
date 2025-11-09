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
            'status' => 'sometimes|in:present,absent,excused,late_in,early_out,half_day,on_leave,sick',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'recorded_by' => 'nullable|exists:users,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
