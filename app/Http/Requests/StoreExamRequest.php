<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Exam model currently empty; keep permissive
        return [
            'circle_id' => 'required|exists:circles,id',
            'student_id' => 'required|exists:students,id',
            'exam_type' => 'required|in:stage,juzz',
            'exam_date_g' => 'required|date',
            'exam_date_h' => 'nullable|string',
            'juzz' => 'nullable|integer|min:1|max:30',
            'stage' => 'nullable|integer|min:1|max:10',
            'total_points' => 'nullable|integer|min:0',
            'total_grade' => 'nullable|string',
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
            $examType = $data['exam_type'] ?? null;
            $juzz = $data['juzz'] ?? null;
            $stage = $data['stage'] ?? null;

            if ($examType === 'juzz' && ($juzz === null || $juzz < 1 || $juzz > 30)) {
                $validator->errors()->add('juzz', 'The juzz must be between 1 and 30 for juzz exams.');
            }

            if ($examType === 'stage' && ($stage === null || $stage < 1 || $stage > 10)) {
                $validator->errors()->add('stage', 'The stage must be between 1 and 10 for stage exams.');
            }
        });
    }
}
