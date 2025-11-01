<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('exam_type') ? $this->route('exam_type')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'name' => 'sometimes|required|string|max:255',
            // 'part_required' removed
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
