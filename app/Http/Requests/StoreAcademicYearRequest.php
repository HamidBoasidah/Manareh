<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mosque_id' => 'required|exists:mosques,id',
            'name' => 'required|string|max:255',
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
