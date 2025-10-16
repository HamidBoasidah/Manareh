<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalFacilityCategoryRequest extends FormRequest
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
        $categoryId = $this->route('medical_facility_category') ? $this->route('medical_facility_category')->id : null;
        return [
            'name_ar' => 'sometimes|required|string|max:255|unique:medical_facility_categories,name_ar,' . $categoryId,
            'name_en' => 'sometimes|required|string|max:255|unique:medical_facility_categories,name_en,' . $categoryId,
            'is_active' => 'nullable|boolean',
            'is_parentable' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
