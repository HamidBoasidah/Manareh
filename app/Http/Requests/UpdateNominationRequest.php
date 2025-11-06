<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Exam;

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
            'nomination_type' => ['sometimes','required', Rule::in(['supervisor_nomination','ideal_student','reader_of_month'])],
            'status' => 'sometimes|required|in:submitted,approved,rejected',
            // allow linking to an existing exam or providing exam details for creation
            'exam_id' => 'sometimes|nullable|exists:exams,id',
            // conditional exam fields when nomination is made by supervisor
            'exam_type' => ['sometimes','required_if:nomination_type,supervisor_nomination', Rule::in(Exam::examTypes())],
            'exam_part' => 'sometimes|required_if:nomination_type,supervisor_nomination|integer|min:1|max:30',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'term_id' => 'nullable|exists:terms,id',
            'nominated_by' => 'nullable|exists:users,id',

            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();
            $examId = $data['exam_id'] ?? null;
            // only validate range when nomination is supervisor's
            if (($data['nomination_type'] ?? null) === 'supervisor_nomination') {
                $examType = $data['exam_type'] ?? null;
                $part = isset($data['exam_part']) ? (int) $data['exam_part'] : null;

                // require either an existing exam_id or exam details
                if (empty($examId) && empty($examType)) {
                    $validator->errors()->add('exam_type', 'Either select an existing exam or provide exam details (type and part).');
                }

                if ($examType === 'stage' && ($part === null || $part < 1 || $part > 10)) {
                    $validator->errors()->add('exam_part', 'The exam part must be between 1 and 10 for stage exams.');
                }
                if ($examType === 'juzz' && ($part === null || $part < 1 || $part > 30)) {
                    $validator->errors()->add('exam_part', 'The exam part must be between 1 and 30 for juzz exams.');
                }
            }
        });
    }
}
