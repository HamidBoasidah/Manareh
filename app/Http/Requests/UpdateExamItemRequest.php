<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('exam_item') ? $this->route('exam_item')->id : null;

        return [
            'exam_id' => 'sometimes|required|exists:exams,id',
            'item_key' => 'sometimes|required|string|max:255',
            'max_points' => 'nullable|integer',
            'score_points' => 'nullable|integer',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
