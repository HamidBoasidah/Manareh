<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mosque_id' => 'required|exists:mosques,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'activity_date_g' => 'nullable|date',
            'activity_date_h' => 'nullable|string|max:50',
            'place' => 'nullable|string|max:255',
            'created_by' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
