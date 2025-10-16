<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalFacilityRequest extends FormRequest
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
        $facilityId = $this->route('medical_facility') ? $this->route('medical_facility')->id : null;
        return [
            'name_ar' => 'sometimes|required|string|max:255|unique:medical_facilities,name_ar,' . $facilityId,
            'name_en' => 'sometimes|required|string|max:255|unique:medical_facilities,name_en,' . $facilityId,
            'address' => 'nullable|string|max:500',
            'phone_number' => ['nullable','regex:/^\d{9}$/'],
            'landline_number' => ['nullable','regex:/^\d{8}$/'],
            'whatsapp_number' => ['nullable','regex:/^\d{9}$/'],
            'facility_ownership_id' => 'sometimes|required|exists:facility_ownerships,id',
            'governorate_id' => 'sometimes|required|exists:governorates,id',
            'district_id' => 'sometimes|required|exists:districts,id',
            'area_id' => 'sometimes|required|exists:areas,id',
            'medical_facility_category_id' => 'sometimes|required|exists:medical_facility_categories,id',
            'parent_id' => 'nullable|exists:medical_facilities,id',
            'is_general' => 'nullable|boolean',
            'specialty_id' => 'nullable|exists:specialties,id',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
