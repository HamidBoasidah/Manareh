<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNominationRequest extends FormRequest
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
            'nomination_type' => 'required|string|max:100',
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
