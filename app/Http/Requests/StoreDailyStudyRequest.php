<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyStudyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_id' => 'required|exists:daily_study_sessions,id',
            'student_id' => 'required|exists:students,id',
            'hifz_from_sura_id' => 'nullable|exists:quran_suras,id',
            'hifz_from_ayah' => 'nullable|integer',
            'hifz_to_sura_id' => 'nullable|exists:quran_suras,id',
            'hifz_to_ayah' => 'nullable|integer',
            'hifz_pages' => 'nullable|integer',
            'murajaah_from_sura_id' => 'nullable|exists:quran_suras,id',
            'murajaah_from_ayah' => 'nullable|integer',
            'murajaah_to_sura_id' => 'nullable|exists:quran_suras,id',
            'murajaah_to_ayah' => 'nullable|integer',
            'murajaah_pages' => 'nullable|integer',
            'points' => 'nullable|integer',
            'attendance_status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
