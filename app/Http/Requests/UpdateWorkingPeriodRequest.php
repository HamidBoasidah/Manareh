<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkingPeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'day' => 'sometimes|required|string|max:20',
            'from_time' => 'sometimes|required|date_format:H:i:s',
            'to_time' => 'sometimes|required|date_format:H:i:s|after:from_time',
            'is_active' => 'nullable|boolean',
            'medical_facility_id' => 'sometimes|required|exists:medical_facilities,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
