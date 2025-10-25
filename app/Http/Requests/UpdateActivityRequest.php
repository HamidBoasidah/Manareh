<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $activityId = $this->route('activity') ? $this->route('activity')->id : null;

        return [
            'mosque_id' => 'sometimes|required|exists:mosques,id',
            'title' => 'sometimes|required|string|max:255',
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
