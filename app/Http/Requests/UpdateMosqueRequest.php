<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMosqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('mosque') ? $this->route('mosque')->id : null;

        return [
            'name' => 'sometimes|required|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
