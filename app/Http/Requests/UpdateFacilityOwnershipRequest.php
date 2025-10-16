<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacilityOwnershipRequest extends FormRequest
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
        $ownershipId = $this->route('facility_ownership') ? $this->route('facility_ownership')->id : null;
        return [
            'name_ar' => 'sometimes|required|string|max:255|unique:facility_ownerships,name_ar,' . $ownershipId,
            'name_en' => 'sometimes|required|string|max:255|unique:facility_ownerships,name_en,' . $ownershipId,
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
