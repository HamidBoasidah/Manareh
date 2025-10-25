<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $academicYearId = $this->route('academic_year') ? $this->route('academic_year')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'name' => 'sometimes|required|string|max:255',
            'start_date_g' => 'nullable|date',
            'end_date_g' => 'nullable|date',
            'start_date_h' => 'nullable|string|max:50',
            'end_date_h' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
