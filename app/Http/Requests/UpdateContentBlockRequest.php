<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentBlockRequest extends FormRequest
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
            'type' => 'sometimes|required|string|max:255',
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => ['nullable', 'regex:/^\d{9}$/'],
            'mobile' => ['nullable', 'regex:/^\d{9}$/'],
            'email' => 'nullable|email|max:255',
            'whatsapp_url' => 'nullable|string|max:255',
            'whatsapp_label' => 'nullable|string|max:255',
            'phone_number' => ['nullable', 'regex:/^\d{9}$/'],
            'phone_label' => 'nullable|string|max:255',
            'attachment' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
