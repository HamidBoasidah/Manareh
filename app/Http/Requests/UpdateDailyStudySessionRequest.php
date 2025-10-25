<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyStudySessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('daily_study_session') ? $this->route('daily_study_session')->id : null;

        return [
            'circle_id' => 'sometimes|required|exists:circles,id',
            'session_date_g' => 'nullable|date',
            'session_date_h' => 'nullable|string|max:50',
            'created_by' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
