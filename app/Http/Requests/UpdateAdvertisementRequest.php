<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdvertisementRequest extends FormRequest
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
        $adId = $this->route('advertisement') ? $this->route('advertisement')->id : null;
        return [
            'title' => 'sometimes|required|string|max:255|unique:advertisements,title,' . $adId,
            'description' => 'nullable|string',
            'attachment' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:pending,active,rejected',
            'phone_number' => ['nullable','regex:/^\d{9}$/'],
            'whatsapp_number' => ['nullable','regex:/^\d{9}$/'],
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
