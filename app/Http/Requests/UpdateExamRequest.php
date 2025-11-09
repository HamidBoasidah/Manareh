<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'circle_id' => 'sometimes|required|exists:circles,id',
            'student_id' => 'sometimes|required|exists:students,id',
            'exam_type' => 'sometimes|required|in:stage,juzz',
            'exam_date_g' => 'sometimes|required|date',
            'exam_date_h' => 'nullable|string',
            'juzz' => 'nullable|integer|min:1|max:30',
            'stage' => 'nullable|integer|min:1|max:10',
            'total_points' => 'nullable|numeric|min:0',
            'total_grade' => 'nullable|string',
            // allow bulk updating of exam items from the frontend
            'items' => 'sometimes|array',
            'items.*.id' => 'required_with:items|integer|exists:exam_items,id',
            'items.*.score_points' => 'required_with:items|numeric|min:0',
            'remarks' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validated();
            $examType = $data['exam_type'] ?? $this->input('exam_type');
            $juzz = $data['juzz'] ?? $this->input('juzz');
            $stage = $data['stage'] ?? $this->input('stage');

            if ($examType === 'juzz' && ($juzz === null || $juzz < 1 || $juzz > 30)) {
                $validator->errors()->add('juzz', 'The juzz must be between 1 and 30 for juzz exams.');
            }

            if ($examType === 'stage' && ($stage === null || $stage < 1 || $stage > 10)) {
                $validator->errors()->add('stage', 'The stage must be between 1 and 10 for stage exams.');
            }
        });
    }
}
