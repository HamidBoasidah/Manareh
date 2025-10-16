<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalServiceRequest extends FormRequest
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
        $serviceId = $this->route('medical_service') ? $this->route('medical_service')->id : null;
        return [
            'name_ar' => 'sometimes|required|string|max:255|unique:medical_services,name_ar,' . $serviceId,
            'name_en' => 'sometimes|required|string|max:255|unique:medical_services,name_en,' . $serviceId,
            'is_active' => 'nullable|boolean',
            'medical_facility_id' => 'sometimes|required|exists:medical_facilities,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
