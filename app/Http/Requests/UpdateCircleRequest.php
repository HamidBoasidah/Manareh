<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCircleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $circleId = $this->route('circle') ? $this->route('circle')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'classification_id' => 'nullable|exists:circle_classifications,id',
            'name' => 'sometimes|required|string|max:255',
            'capacity' => 'nullable|integer',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
