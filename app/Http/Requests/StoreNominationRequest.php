<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Exam;

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
            'nomination_type' => ['required', Rule::in(['supervisor_nomination','ideal_student','reader_of_month'])],
            'status' => 'nullable|in:submitted,approved,rejected',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'term_id' => 'nullable|exists:terms,id',
            'nominated_by' => 'nullable|exists:users,id',
            // allow linking to an existing exam or providing exam details for creation
            'exam_id' => 'nullable|exists:exams,id',
            // conditional exam fields when nomination is made by supervisor
            'exam_type' => ['required_if:nomination_type,supervisor_nomination', Rule::in(Exam::examTypes())],
            'exam_part' => 'required_if:nomination_type,supervisor_nomination|integer|min:1|max:30',

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
            if (($data['nomination_type'] ?? null) === 'supervisor_nomination') {
                $examId = $data['exam_id'] ?? null;
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
