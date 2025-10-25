<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNominationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('nomination') ? $this->route('nomination')->id : null;

        return [
            'circle_id' => 'sometimes|required|exists:circles,id',
            'student_id' => 'sometimes|required|exists:students,id',
            'nomination_type' => 'sometimes|required|string|max:100',
            'month_ref' => 'nullable|string|max:50',
            'term_id' => 'nullable|exists:terms,id',
            'nominated_by' => 'nullable|exists:users,id',
            'status' => 'nullable|string|max:50',
            'approved_by' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
