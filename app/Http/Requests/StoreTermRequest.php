<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:191',
            'start_date_g' => 'nullable|date',
            'end_date_g' => 'nullable|date|after_or_equal:start_date_g',
            'start_date_h' => 'nullable|string|max:50',
            'end_date_h' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ];
    }
}
