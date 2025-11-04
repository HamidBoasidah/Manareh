<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('staff_assignment') ? $this->route('staff_assignment')->id : null;

        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'circle_id' => 'sometimes|required|exists:circles,id',
            'role_in_circle' => 'nullable|string|max:255',
            'role_id' => 'sometimes|nullable|exists:roles,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
